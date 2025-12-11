const express = require('express');
const axios = require('axios');
const math = require('mathjs');
const util = require('util');
const crypto = require('crypto');

global.TextEncoder = util.TextEncoder;

const app = express();
const port = process.env.PORT || 3000;

const msecHeaders = {
    'accept': '*/*',
    'accept-language': 'zh-CN,zh;q=0.9',
    'cache-control': 'no-cache',
    'pragma': 'no-cache',
    'priority': 'u=1, i',
    'referer': 'https://ssyoutube.com/en785ie/',
    'sec-ch-ua': '"Chromium";v="128", "Not;A=Brand";v="24", "Google Chrome";v="128"',
    'sec-ch-ua-mobile': '?0',
    'sec-ch-ua-platform': '"macOS"',
    'sec-fetch-dest': 'empty',
    'sec-fetch-mode': 'cors',
    'sec-fetch-site': 'same-origin',
    'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36'
};

async function getMsec() {
    try {
        console.log('Attempting to get msec data...');
        const response = await axios.get('https://ssyoutube.com/msec', { headers: msecHeaders });
        console.log('Msec data received:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error in getMsec:', error.message);
        if (error.response) {
            console.error('Response status:', error.response.status);
            console.error('Response data:', error.response.data);
        }
        return null;
    }
}

function J(W, m) {
    return function (z) {
        if (Array.isArray(z)) {
            return z;
        }
    }(W) || function (z, H) {
        var A = null == z ? null : "undefined" != typeof Symbol && z[Symbol.iterator] || z["@@iterator"];
        if (null != A) {
            var V, j, x, U, S = [], b = true, O = false;
            try {
                if (x = (A = A.call(z)).next, 0 === H) {
                    if (Object(A) !== A) return;
                    b = false;
                } else {
                    for (; !(b = (V = x.call(A)).done) && (S.push(V.value), S.length !== H); b = true);
                }
            } catch (L) {
                O = true;
                j = L;
            } finally {
                try {
                    if (!b && null != A.return && (U = A.return(), Object(U) !== U)) return;
                } finally {
                    if (O) throw j;
                }
            }
            return S;
        }
    }(W, m) || B(W, m) || function () {
        throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    }();
}

function G(W) {
    return function (z) {
        if (Array.isArray(z)) return k(z);
    }(W) || function (z) {
        if ("undefined" != typeof Symbol && null != z[Symbol.iterator] || null != z["@@iterator"]) return Array.from(z);
    }(W) || B(W) || function () {
        throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    }();
}

function B(W, m) {
    if (W) {
        if ("string" == typeof W) return k(W, m);
        var z = Object.prototype.toString.call(W).slice(8, -1);
        return "Object" === z && W.constructor && (z = W.constructor.name), "Map" === z || "Set" === z ? Array.from(W) : "Arguments" === z || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(z) ? k(W, m) : void 0;
    }
}

function k(W, m) {
    (null == m || m > W.length) && (m = W.length);
    for (var z = 0, H = new Array(m); z < m; z++) H[z] = W[z];
    return H;
}

var Y = [
    function (W) { return W.split("").reverse().join(""); },
    function (W, m) { m = W.length - m % W.length; return W.substring(m) + W.substring(0, m); },
    function (W, m) { return W.substring(m % W.length); },
    function (W, m) { return W.substring(0, W.length - m % W.length); }
];

function p(W, m) {
    var H = G(m);
    H.reverse();
    H.forEach(function (f) {
        var A = J(f, 2), V = A[0], j = A[1];
        V in Y && (W = Y[V](W, j));
    });
    return W;
}

function z(W, m, z, H) {
    W = function (f, A) {
        var V, j, x, U, S, b = "", O = 0;
        for (f = f.replace(/[^A-Za-z0-9\+\/\=]/g, ""), 64 == A.length && (A += "="), f += ["", "===", "==", "="][f.length % 4]; O < f.length;) {
            V = (V = A.indexOf(f.charAt(O++))) << 2 | (j = A.indexOf(f.charAt(O++))) >> 4;
            j = (15 & j) << 4 | (U = A.indexOf(f.charAt(O++))) >> 2;
            x = (3 & U) << 6 | (S = A.indexOf(f.charAt(O++)));
            b += String.fromCharCode(V);
            64 != U && (b += String.fromCharCode(j));
            64 != S && (b += String.fromCharCode(x));
        }
        return b;
    }(W = (W = p(W, "string" == typeof z ? JSON.parse(z) : z)).padEnd(W.length % 4, "="), H);
    return p(W, "string" == typeof m ? JSON.parse(m) : m);
}

var S = function (L) {
    return z(L, "[[2,5],[0,7],[3,4],[0,64],[1,31],[1,97],[0,83],[2,8]]", "[[2,5],[2,5],[2,1],[2,3],[0,16],[1,84]]", 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/');
};

function x(url) {
    var D = new TextEncoder().encode(url);
    var T = crypto.createHash('sha256').update(D).digest();
    var Q = Array.from(new Uint8Array(T));
    return Q.map(function (E) {
        return E.toString(16).padStart(2, "0");
    }).join("");
}

function jm(url, D) {
    var E = D ? Date.now() - D : 0;
    Math.abs(E) < 60000 && (E = 0);
    var M = Date.now() - E;
    var g = {};
    g.t0 = url;
    g.t1 = M;
    g.t2 = 1726140555932;
    g.t3 = E;
    g.t4 = x("".concat(url).concat(M).concat(S("3czMlJWM0kjZjVTYiFWNmhzNCv+t4hptnT2BXLyEWYiZmZiFTNxITO1gDN1YjY0kTYwgTN0cjN1AjZ5QTO5QGO0YWYlhjN3UTO5MmY5MzNwUmMwUWOkNTYzgTY")));
    return g;
}

app.get('/api', async (req, res) => {
    try {
        const url = req.query.url;
        if (!url) {
            return res.status(400).json({ error: 'URL parameter is required' });
        }

        console.log('Processing URL:', url);

        const data = await getMsec();
        if (!data || !data.msec) {
            throw new Error("Failed to get msec data");
        }

        const D = math.floor(1000 * data.msec);
        const jmResult = jm(url, D);

        console.log('jm result:', jmResult);

        const params = {
            _s: jmResult.t4,
            _ts: jmResult.t2,
            _tsc: jmResult.t3,
            ts: jmResult.t1,
            url: jmResult.t0
        };

        const apiUrl = 'https://api.ssyoutube.com/api/convert';
        const response = await axios.post(apiUrl, params, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        console.log('API response received');
        res.json(response.data);
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
            res.status(500).json({ error: 'No response received from API' });
        } else {
            res.status(500).json({ error: 'Internal Server Error' });
        }
    }
});

app.listen(port, () => {
    console.log(`Server running on port ${port}`);
});

