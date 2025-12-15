const crypto = require('crypto');
const decryptData = encryptedData => {
    try {
        const cleanedData = encryptedData.replace(/\s/g, "");
        const decodedBuffer = Buffer.from(cleanedData, 'base64');
        if (decodedBuffer.length < 16) {
            throw new Error("Invalid format: insufficient length");
        }
        const iv = decodedBuffer.slice(0, 16);
        const encrypted = decodedBuffer.slice(16);

        function secretKeyHex() {
            const seed = 0xA5C3D2E1 >>> 0;
            const enc = Uint8Array.from([181, 174, 35, 85, 128, 226, 153, 247, 184, 242, 176, 176, 171, 116, 232, 57]);
            const rnd = s => {
                s = s + 0x6D2B79F5 >>> 0;
                let t = Math.imul(s ^ s >>> 15, 1 | s) >>> 0;
                t = (t ^ t >>> 7) + Math.imul(t ^ t >>> 7, 61 | t) >>> 0;
                return (t ^ t >>> 14) >>> 0;
            };
            const out = new Uint8Array(enc.length);
            for (let i = 0; i < enc.length; i++) {
                out[i] = enc[i] ^ rnd(seed + i >>> 0) & 0xFF;
            }
            let hex = "";
            for (let i = 0; i < out.length; i++) {
                const h = out[i].toString(16).padStart(2, "0");
                hex += h;
            }
            return hex.toUpperCase();
        }

        const keyHex = secretKeyHex();
        const keyBytes = keyHex.match(/[\dA-F]{2}/gi).map(byte => parseInt(byte, 16));
        const key = Buffer.from(keyBytes);
        const decipher = crypto.createDecipheriv('aes-128-cbc', key, iv);
        let decrypted = decipher.update(encrypted);
        decrypted = Buffer.concat([decrypted, decipher.final()]);
        const result = decrypted.toString('utf8');
        return JSON.parse(result);
    } catch (err) {
        console.error('Decryption error:', err);
        throw new Error(`Decryption failed: ${err.message}`);
    }
};


const express = require('express');
const axios = require("axios");

const app = express();
const port = process.env.PORT || 3002;

// 2. 公共 headers
const commonHeaders = {
    "User-Agent":
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36",
};

// 3. 第一步：获取 cdn_url
const session = axios.create({
    headers: {
        Accept: "*/*",
        "Accept-Language": "zh-CN,zh;q=0.9",
        "Cache-Control": "no-cache",
        Connection: "keep-alive",
        Origin: "https://yt.savetube.me",
        Pragma: "no-cache",
        Referer: "https://yt.savetube.me/",
        "Sec-Fetch-Dest": "empty",
        "Sec-Fetch-Mode": "cors",
        "Sec-Fetch-Site": "same-site",
        "sec-ch-ua":
            '"Chromium";v="140", "Not=A?Brand";v="24", "Google Chrome";v="140"',
        "sec-ch-ua-mobile": "?0",
        "sec-ch-ua-platform": '"macOS"',
        ...commonHeaders,
    },
});

async function main(url, quality, type) {
    try {
        const res1 = await session.get(
            "https://media.savetube.me/api/random-cdn"
        );
        const cdnUrl = res1.data.cdn;

        // 4. 第二步：POST 请求
        const res2 = await axios.post(
            `https://${cdnUrl}/v2/info`,
            {
                url: url,
            },
            {
                headers: {
                    accept: "application/json, text/plain, */*",
                    "accept-language": "zh-CN,zh;q=0.9",
                    "cache-control": "no-cache",
                    "content-type": "application/json",
                    origin: "https://yt.savetube.me",
                    pragma: "no-cache",
                    priority: "u=1, i",
                    referer: "https://yt.savetube.me/",
                    "sec-ch-ua":
                        '"Chromium";v="140", "Not=A?Brand";v="24", "Google Chrome";v="140"',
                    "sec-ch-ua-mobile": "?0",
                    "sec-ch-ua-platform": '"macOS"',
                    "sec-fetch-dest": "empty",
                    "sec-fetch-mode": "cors",
                    "sec-fetch-site": "cross-site",
                    ...commonHeaders,
                },
            }
        );

        // 5. 调用 decryptData
        const encrypted = res2.data.data;
        const decrypted = decryptData(encrypted);

        if(!quality || !type) {
            return decrypted;
        }

        const res3 = await axios.post(
            `https://${cdnUrl}/download`,
            {
                downloadType: type,
                quality: quality,
                key: decrypted.key,
            },
            {
                headers: {
                    'accept': '*/*',
                    'accept-language': 'zh-CN,zh;q=0.9',
                    'cache-control': 'no-cache',
                    'content-type': 'application/json',
                    'origin': 'https://yt.savetube.me',
                    'pragma': 'no-cache',
                    'priority': 'u=1, i',
                    'referer': 'https://yt.savetube.me/',
                    'sec-ch-ua': '"Chromium";v="140", "Not=A?Brand";v="24", "Google Chrome";v="140"',
                    'sec-ch-ua-mobile': '?0',
                    'sec-ch-ua-platform': '"macOS"',
                    'sec-fetch-dest': 'empty',
                    'sec-fetch-mode': 'cors',
                    'sec-fetch-site': 'cross-site',
                    ...commonHeaders,
                },
            }
        );

        return res3.data;
    } catch (err) {
        return {
            'err': "请求或解密出错:" + err.message
        }
    }
}


app.get('/api', async (req, res) => {
    try {
        const url = req.query.url;
        const quality = req.query.quality;
        const type = req.query.type;
        if (!url) {
            return res.status(400).json({error: 'URL parameter is required'});
        }
        // if (!quality) {
        //     return res.status(400).json({error: 'quality parameter is required'});
        // }
        // if (!type) {
        //     return res.status(400).json({error: 'type parameter is required'});
        // }

        console.log('Processing URL:', url);

        const jmResult = await main(url, quality, type);
        if (!jmResult) {
            throw new Error("Failed to get msec data");
        }
        res.json(jmResult);
    } catch (error) {
        console.error('Error:', error.message);
        if (error.response) {
            console.error('Error response:', error.response.data);
            console.error('Status:', error.response.status);
            res.status(error.response.status).json({
                error: 'API Error',
                details: error.response.data
            });
        } else if (error.request) {
            console.error('No response received:', error.request);
            res.status(500).json({error: 'No response received from API'});
        } else {
            res.status(500).json({error: 'Internal Server Error'});
        }
    }
});

app.listen(port, () => {
    console.log(`Server running on port ${port}`);
});