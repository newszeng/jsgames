(()=>{"use strict";var e,t={50:(e,t,r)=>{var a,n=r(294),o=r(935),i=r(766),s=r(804);!function(e){e[e.Game=0]="Game",e[e.Editor=1]="Editor",e[e.About=2]="About",e[e.Settings=3]="Settings",e[e.Statistics=4]="Statistics",e[e.Category=5]="Category"}(a||(a={}));var l,c,g,d=r(949);!function(e){e[e.None=0]="None",e[e.GameResult=1]="GameResult"}(l||(l={})),function(e){e[e.New=0]="New",e[e.Playing=1]="Playing",e[e.Won=2]="Won",e[e.Lost=3]="Lost"}(c||(c={})),function(e){e[e.FreeToPlay=0]="FreeToPlay",e[e.DailyChallenge=1]="DailyChallenge",e[e.CustomMode=2]="CustomMode"}(g||(g={}));var m=r(742);function h(e){const t=(new TextEncoder).encode(e);return m.fromByteArray(t)}function u(e,t){let r=t;return e&&(r=r.replace(new RegExp(/[\xe0\xe1\xe2\xe3\xe4\xe5]/g),"a"),r=r.replace(new RegExp(/\xe7/g),"c"),r=r.replace(new RegExp(/[\xe8\xe9\xea\xeb]/g),"e"),r=r.replace(new RegExp(/[\xec\xed\xee\xef]/g),"i"),r=r.replace(new RegExp(/\xf1/g),"n"),r=r.replace(new RegExp(/[\xf2\xf3\xf4\xf5\xf6]/g),"o"),r=r.replace(new RegExp(/[\xf9\xfa\xfb\xfc]/g),"u"),r=r.replace(new RegExp(/[\xfd\xff]/g),"y")),r}function p(e,t,r=!1){const a=Math.abs(t.getTime()-e.getTime()),n=(Math.floor(a/1e3)%60).toString().padStart(2,"0"),o=(Math.floor(a/1e3/60)%60).toString().padStart(2,"0"),i=Math.floor(a/1e3/60/60).toString().padStart(2,"0");return`${r?`${i}:`:""}${o}:${n}`}class f{root;gameType;remainingAttempts;gameStage;gameStartAt;gameFinishAt;hiddenWord;goodLetters;badLetters;currentCategory;minWordLength;maxWordLength;random;playedKeys;dictionary;constructor(e){this.root=e,this.remainingAttempts=8,this.gameStage=c.New,this.gameStartAt=new Date,this.gameFinishAt=new Date,this.hiddenWord="",this.goodLetters=["_"],this.badLetters=[],this.currentCategory="Random",this.minWordLength=5,this.maxWordLength=11,this.gameType=g.FreeToPlay,this.random=e=>Math.floor(Math.random()*e),this.playedKeys=[],this.dictionary=[]}init(){(0,d.rC)(this,{remainingAttempts:d.LO,gameStage:d.LO,hiddenWord:d.LO,goodLetters:d.LO,badLetters:d.LO,currentCategory:d.LO,gameType:d.LO,playedKeys:d.LO,gameReset:d.aD,handleLetter:d.aD,giveUp:d.aD,addPlayedKey:d.aD,onDictionaryLoaded:d.aD})}async loadAssets(){let e=await fetch("dic/target_en.json"),t=await e.json();this.onDictionaryLoaded(t)}onDictionaryLoaded(e){this.dictionary=e,this.gameReset()}gameReset(){this.goodLetters=["_"],this.badLetters=[],this.gameStage=c.New,this.remainingAttempts=8,this.playedKeys=[];let e=new URL(window.location.toString()).searchParams.get("challenge");if(e)return this.currentCategory="Custom",e=function(e,t="utf-8"){const r=m.toByteArray(e);return new TextDecoder(t).decode(r)}(e),e=e.replace(" ","_"),this.hiddenWord=e,void(this.gameType=g.CustomMode);if(this.root.LocalStorageStore.prefersDailyChallenge&&this.root.LocalStorageStore.dailyPlayed<this.root.getTodaySeed()){this.currentCategory="Today’s";const e=(t=this.root.getTodaySeed(),function(){let e=t+=1831565813;return e=Math.imul(e^e>>>15,1|e),e^=e+Math.imul(e^e>>>7,61|e),((e^e>>>14)>>>0)/4294967296}),r=t=>Math.floor(e()*t);this.random=r,this.gameType=g.DailyChallenge}else this.random=e=>Math.floor(Math.random()*e),this.gameType=g.FreeToPlay;var t;this.hiddenWord=this.getRandomWord(this.filterDictionary())}filterDictionary(){return this.dictionary.filter((e=>e.length>=this.minWordLength&&e.length<=this.maxWordLength))}getRandomWord(e){return e[this.random(e.length)]||"thoughtless"}giveUp(){if(this.gameStage===c.Playing)return this.gameStage=c.Lost,this.gameFinishAt=new Date,this.root.UiStore.toggleModal(l.GameResult),void this.root.LocalStorageStore.addGameResult({isWin:!1,time:this.gameFinishAt.getTime()-this.gameStartAt.getTime(),goodGuesses:this.goodLetters.length,badGuesses:this.badLetters.length,isDaily:this.gameType===g.DailyChallenge,perfect:this.badLetters.length<1});if(this.gameType===g.CustomMode){const e=new URL(window.location.toString());return window.history.pushState({},"",e.origin),void this.changeCategory("Random")}if(this.gameType===g.DailyChallenge)return this.root.LocalStorageStore.recordDailyChallenge(this.root.getTodaySeed()),void this.changeCategory("Random");this.gameReset()}changeCategory(e){if(this.gameType===g.CustomMode){const e=new URL(window.location.toString());window.history.pushState({},"",e.origin)}switch(this.gameType===g.DailyChallenge&&this.root.LocalStorageStore.recordDailyChallenge(this.root.getTodaySeed()),e){case"Easy":this.minWordLength=4,this.maxWordLength=7;break;case"Medium":this.minWordLength=8,this.maxWordLength=11;break;case"Hard":this.minWordLength=11,this.maxWordLength=11;break;default:this.minWordLength=4,this.maxWordLength=11}this.currentCategory=e,this.gameReset()}addPlayedKey(e){this.playedKeys.push(e)}handleLetter(e){if(this.badLetters.includes(e)||this.goodLetters.includes(e))return;if(this.gameStage!==c.New&&this.gameStage!==c.Playing)return;this.gameStage!==c.Playing&&(this.gameStage=c.Playing,this.gameStartAt=new Date),this.hiddenWord.includes(e)?this.goodLetters.push(e):(this.badLetters.push(e),this.remainingAttempts--);if(this.hiddenWord.split("").every((e=>this.goodLetters.includes(e)))&&(this.gameStage=c.Won,this.gameFinishAt=new Date,this.root.UiStore.toggleModal(l.GameResult),this.root.LocalStorageStore.addGameResult({isWin:!0,time:this.gameFinishAt.getTime()-this.gameStartAt.getTime(),goodGuesses:this.goodLetters.length,badGuesses:this.badLetters.length,isDaily:this.gameType===g.DailyChallenge,perfect:this.badLetters.length<1}),this.gameType===g.DailyChallenge&&(this.root.LocalStorageStore.recordDailyChallenge(this.root.getTodaySeed()),this.currentCategory="Random"),this.gameType==g.CustomMode)){const e=new URL(window.location.toString());window.history.pushState({},"",e.origin),this.currentCategory="Random"}if(0===this.remainingAttempts&&(this.gameStage=c.Lost,this.gameFinishAt=new Date,this.root.UiStore.toggleModal(l.GameResult),this.root.LocalStorageStore.addGameResult({isWin:!1,time:this.gameFinishAt.getTime()-this.gameStartAt.getTime(),goodGuesses:this.goodLetters.length,badGuesses:this.badLetters.length,isDaily:this.gameType===g.DailyChallenge,perfect:this.badLetters.length<1}),this.gameType===g.DailyChallenge&&(this.root.LocalStorageStore.recordDailyChallenge(this.root.getTodaySeed()),this.currentCategory="Random"),this.gameType==g.CustomMode)){const e=new URL(window.location.toString());window.history.pushState({},"",e.origin),this.currentCategory="Random"}}isLetterGood(e){return this.hiddenWord.split("").includes(e)}}var x=r(533);class b{root;darkTheme;gameStats;dailyPlayed;prefersDailyChallenge;constructor(e){this.root=e,this.darkTheme=!1,this.gameStats=[],this.dailyPlayed=0,this.prefersDailyChallenge=!0}init(){(0,d.rC)(this,{darkTheme:d.LO,gameStats:d.LO,dailyPlayed:d.LO,prefersDailyChallenge:d.LO,addGameResult:d.aD,recordDailyChallenge:d.aD,togglePrefDailyChallenge:d.aD,getTotalWins:d.Fl,getTotalLosses:d.Fl,getTotalGoodGuesses:d.Fl,getTotalBadGuesses:d.Fl,getTotalPerfectGames:d.Fl,getTotalDailyWins:d.Fl}),(0,x.Ko)(this,{name:"DataStorage",properties:["darkTheme","gameStats","dailyPlayed","prefersDailyChallenge"],storage:window.localStorage})}get getTotalWins(){return this.gameStats.filter((e=>e.isWin)).length}get getTotalLosses(){return this.gameStats.filter((e=>!1===e.isWin)).length}get getTotalGoodGuesses(){return this.gameStats.map((e=>e.goodGuesses)).reduce(((e,t)=>e+t),0)}get getTotalBadGuesses(){return this.gameStats.map((e=>e.badGuesses)).reduce(((e,t)=>e+t),0)}get getTotalPerfectGames(){return this.gameStats.filter((e=>e.perfect)).length}get getTotalDailyWins(){return this.gameStats.filter((e=>e.isDaily&&e.isWin)).length}addGameResult(e){this.gameStats.push(e)}recordDailyChallenge(e){this.dailyPlayed=e}togglePrefDailyChallenge(){this.prefersDailyChallenge=!this.prefersDailyChallenge}}String.prototype.f=function(e){let t=this;for(const[r,a]of Object.entries(e)){const e="{"+r+"}";t=t.replace(e,String(a))}return String(t)};class w{keyboard;charsReplacer;constructor(e){const t=e;if(t&&t.keyboard?this.keyboard=t.keyboard:this.keyboard=["a b c d e f g h i","j k l m n o p q r","s t u v w x y z"],t&&t.replace_chars){const e=t.replace_chars;this.charsReplacer=t=>{let r=t;for(const t of e){const e=new RegExp("["+t[0]+"]","g");r=r.replace(e,t[1])}return r}}else t&&void 0!==t.replace_ext_chars?t.replace_ext_chars?this.charsReplacer=e=>u(!0,e):this.charsReplacer=e=>e:this.charsReplacer=e=>u(!0,e)}}class y{root;locale;lang;timerShown;displayPage;muteSound;currentModal;removeTimer;constructor(e){this.root=e,this.lang=function(e){if(e){const t=document.getElementById(e)?.getAttribute("lang");if(t)return t}let t=document.documentElement.getAttribute("lang");return t?(t=t.split("-")[0],t):"en"}(),this.locale=new w,this.timerShown=!0,this.removeTimer=!1,this.displayPage=a.Game,this.muteSound=!1,this.currentModal=l.None}init(){(0,d.rC)(this,{displayPage:d.LO,locale:d.LO,lang:d.LO,timerShown:d.LO,muteSound:d.LO,currentModal:d.LO,removeTimer:d.LO,darkTheme:d.Fl,showHideTimer:d.aD,togglePage:d.aD,toggleDark:d.aD,toggleMute:d.aD,toggleModal:d.aD})}get darkTheme(){return this.root.LocalStorageStore.darkTheme}toggleDark(){this.root.LocalStorageStore.darkTheme=!this.darkTheme}toggleMute(){this.muteSound=!this.muteSound}toggleRemoveTimer(){this.removeTimer=!this.removeTimer}showHideTimer(e){this.timerShown=e}togglePage(e){this.displayPage===e?this.displayPage=a.Game:this.displayPage=e}toggleModal(e){this.currentModal=e}}class S{LocalStorageStore;UiStore;GameStore;todaySeed;constructor(){this.LocalStorageStore=new b(this),this.UiStore=new y(this),this.GameStore=new f(this),this.todaySeed=this.getTodaySeed(),this.init()}init(){this.LocalStorageStore.init(),this.UiStore.init(),this.GameStore.init()}getTodaySeed(){const e=e=>e.toString().padStart(2,"0"),t=new Date,r=`${t.getFullYear()}${e(t.getMonth())}${e(t.getDate())}`;return parseInt(r)}}const k=(0,n.createContext)(void 0);function v(){const e=(0,n.useContext)(k);if(void 0===e)throw new Error("useRootStore must be used within RootStoreProvider");return e}function E(){const{UiStore:e}=v();return e}function L(){const{GameStore:e}=v();return e}k.displayName="StoreContext";const C=(0,i.Pi)((()=>{const e=v();return n.createElement(_,{onClick:()=>e.UiStore.togglePage(a.Category)},n.createElement("div",null,e.GameStore.currentCategory),n.createElement("svg",{className:"pencil",xmlns:"http://www.w3.org/2000/svg",xmlnsXlink:"http://www.w3.org/1999/xlink",version:"1.1",width:"24",height:"24",viewBox:"0 0 24 24"},n.createElement("path",{d:"M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"})))})),_=s.ZP.div`
    background-color: white;
    border-radius: 10px;
    height: 2.2rem;
    width: 8rem;
    margin: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-align: center;

    div {
        text-align: left;
        padding: 5px;
    }

    .pencil {
        margin-left: auto;
        margin-right: 5px;
        width: 1.2rem;
    }
`,T=C,P=(0,i.Pi)((()=>{const e=v();return n.createElement(N,null,n.createElement("div",{onClick:()=>e.UiStore.togglePage(a.Editor)},n.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",xmlnsXlink:"http://www.w3.org/1999/xlink",version:"1.1",width:"24",height:"24",viewBox:"0 0 24 24"},n.createElement("path",{d:"M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z"}))),n.createElement("div",{onClick:()=>e.UiStore.togglePage(a.About)},n.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",xmlnsXlink:"http://www.w3.org/1999/xlink",version:"1.1",width:"24",height:"24",viewBox:"0 0 24 24"},n.createElement("path",{d:"M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z"}))),n.createElement("div",{onClick:()=>e.UiStore.togglePage(a.Settings)},n.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",xmlnsXlink:"http://www.w3.org/1999/xlink",version:"1.1",width:"24",height:"24",viewBox:"0 0 24 24"},n.createElement("path",{d:"M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8M12,10A2,2 0 0,0 10,12A2,2 0 0,0 12,14A2,2 0 0,0 14,12A2,2 0 0,0 12,10M10,22C9.75,22 9.54,21.82 9.5,21.58L9.13,18.93C8.5,18.68 7.96,18.34 7.44,17.94L4.95,18.95C4.73,19.03 4.46,18.95 4.34,18.73L2.34,15.27C2.21,15.05 2.27,14.78 2.46,14.63L4.57,12.97L4.5,12L4.57,11L2.46,9.37C2.27,9.22 2.21,8.95 2.34,8.73L4.34,5.27C4.46,5.05 4.73,4.96 4.95,5.05L7.44,6.05C7.96,5.66 8.5,5.32 9.13,5.07L9.5,2.42C9.54,2.18 9.75,2 10,2H14C14.25,2 14.46,2.18 14.5,2.42L14.87,5.07C15.5,5.32 16.04,5.66 16.56,6.05L19.05,5.05C19.27,4.96 19.54,5.05 19.66,5.27L21.66,8.73C21.79,8.95 21.73,9.22 21.54,9.37L19.43,11L19.5,12L19.43,13L21.54,14.63C21.73,14.78 21.79,15.05 21.66,15.27L19.66,18.73C19.54,18.95 19.27,19.04 19.05,18.95L16.56,17.95C16.04,18.34 15.5,18.68 14.87,18.93L14.5,21.58C14.46,21.82 14.25,22 14,22H10M11.25,4L10.88,6.61C9.68,6.86 8.62,7.5 7.85,8.39L5.44,7.35L4.69,8.65L6.8,10.2C6.4,11.37 6.4,12.64 6.8,13.8L4.68,15.36L5.43,16.66L7.86,15.62C8.63,16.5 9.68,17.14 10.87,17.38L11.24,20H12.76L13.13,17.39C14.32,17.14 15.37,16.5 16.14,15.62L18.57,16.66L19.32,15.36L17.2,13.81C17.6,12.64 17.6,11.37 17.2,10.2L19.31,8.65L18.56,7.35L16.15,8.39C15.38,7.5 14.32,6.86 13.12,6.62L12.75,4H11.25Z"}))),n.createElement("div",{onClick:()=>e.UiStore.togglePage(a.Statistics)},n.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",xmlnsXlink:"http://www.w3.org/1999/xlink",version:"1.1",width:"24",height:"24",viewBox:"0 0 24 24"},n.createElement("path",{d:"M16,11.78L20.24,4.45L21.97,5.45L16.74,14.5L10.23,10.75L5.46,19H22V21H2V3H4V17.54L9.5,8L16,11.78Z"}))),n.createElement("div",{onClick:()=>e.UiStore.toggleMute()},e.UiStore.muteSound?n.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",xmlnsXlink:"http://www.w3.org/1999/xlink",version:"1.1",width:"24",height:"24",viewBox:"0 0 24 24"},n.createElement("path",{d:"M12,4L9.91,6.09L12,8.18M4.27,3L3,4.27L7.73,9H3V15H7L12,20V13.27L16.25,17.53C15.58,18.04 14.83,18.46 14,18.7V20.77C15.38,20.45 16.63,19.82 17.68,18.96L19.73,21L21,19.73L12,10.73M19,12C19,12.94 18.8,13.82 18.46,14.64L19.97,16.15C20.62,14.91 21,13.5 21,12C21,7.72 18,4.14 14,3.23V5.29C16.89,6.15 19,8.83 19,12M16.5,12C16.5,10.23 15.5,8.71 14,7.97V10.18L16.45,12.63C16.5,12.43 16.5,12.21 16.5,12Z"})):n.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",xmlnsXlink:"http://www.w3.org/1999/xlink",version:"1.1",width:"24",height:"24",viewBox:"0 0 24 24"},n.createElement("path",{d:"M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.84 14,18.7V20.77C18,19.86 21,16.28 21,12C21,7.72 18,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16C15.5,15.29 16.5,13.76 16.5,12M3,9V15H7L12,20V4L7,9H3Z"}))))})),G=P,N=s.ZP.div`
    display: flex;
    margin: 10px;
    margin-left: auto;
    div {
        border-radius: 50%;
        width: 34px;
        height: 34px;
        display: inline;
        background-color: #c8deed;
        margin-left: 4px;
        cursor: pointer;

        svg {
            border-radius: 50%;
            border: none;
            height: 23px;
            width: 23px;
            padding: 0px;
            margin: 5px 5px 5px 5px;
            color: #626568;
            text-align: center;
            text-decoration: none !important;
        }
    }
`;function D(){return n.createElement(U,{href:"https://hang-man.org"},n.createElement("img",{src:"./images/icons/logo-hangman.svg"}))}const U=s.ZP.a`
    margin-left: 25px;
    margin-top: 1px;
    img {
        height: 20px;
    }
    @media screen and (max-width: 720px) {
        display: none;
    }
`;function A(){return n.createElement(M,null,n.createElement("div",{className:"header__inner"},n.createElement("div",{className:"header__center"},n.createElement(T,null)),n.createElement("div",{className:"header__center"},n.createElement(D,null)),n.createElement("div",{className:"header__center"},n.createElement(G,null))))}const M=s.ZP.header`
    background-color: #e7ebf1;
    display: flex;
    width:100%;
    user-select: none;
    padding-bottom: 10px;
    margin-top: 5px;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;

    .header__inner {
        width: 100%;
        max-width: 720px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
    }

    .header__center {
        display: flex;
        align-self: center;
    }
`,$={crossButton:s.iv`
        .crossbutton {
            background: none;
            border: none;
            cursor: pointer;
            height: 35px;
            padding: 0;
            position: absolute;
            right: 8px;
            width: 35px;
        }
        .crossbutton::before, .crossbutton::after {
            position: absolute;
            top: 8px;
            left: 17px;
            content: " ";
            height: 20px;
            width: 1px;
            background-color: #333;
        }

        .crossbutton::before {
            transform: rotate(45deg);
        }

        .crossbutton::after {
            transform: rotate(-45deg);
        }
    `,pageCaption:s.iv`
        .page__caption {
            align-items: center;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            display: flex;
            font-size: 24px;
            height: 40px;
            justify-content: center;
            width: 100%;
            position: relative;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    `,defaultButton:s.iv` 
        .button-default {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 35px;
            margin: 3px;
            padding: 4px 14px;
            border-radius: 30px;
            border: none;
            line-height: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0s 0s;
        }
    `},R=s.ZP.div`
    margin-top: -35px;
    position: absolute;
    right: 15px;

    input {
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%2386b7fe'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        border: 1px solid #dee2e6;
        border-top-color: rgb(222, 226, 230);
        border-right-color: rgb(222, 226, 230);
        border-bottom-color: rgb(222, 226, 230);
        border-left-color: rgb(222, 226, 230);
        border-color: #2f55d4 !important;
        border-radius: 2em;
        cursor: pointer;
        height: 2em;
        transition: background-position .15s ease-in-out;
        width: 4em;
    }

    input:checked {
        background-color: #2f55d4;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%23fff'/%3E%3C/svg%3E");
        background-position: 100%;
        border-color: #2f55d4;
    }
`,W=e=>n.createElement(R,null,n.createElement("input",{checked:e.checked,type:"checkbox",onChange:()=>e.onChange()})),B=s.ZP.div`
    margin: 8px;
    position: relative;
    font-size: 18px;
    text-align: left;
    user-select: none;

    .setting__title {
        font-size: 24px;
        font-weight: 700;
        margin-left: 15px;
        text-transform: capitalize;
    }

    .setting__description {
        display: inline-block;
        font-size: 16px;
        margin-left: 15px;
        margin-right: 80px;
        text-align: left;
    }

`,I=e=>n.createElement(B,null,n.createElement("div",{className:"setting__title"},e.title),n.createElement("div",{className:"setting__description"},e.desc),n.createElement(W,{onChange:e.onChange,checked:e.checked})),Z=(0,i.Pi)((()=>{const e=v();return n.createElement(F,null,n.createElement("div",{className:"page__caption"},"Settings",n.createElement("button",{className:"crossbutton",onClick:()=>e.UiStore.togglePage(a.Game)})),n.createElement(I,{checked:e.UiStore.darkTheme,onChange:()=>e.UiStore.toggleDark(),title:"Dark Theme",desc:"Toggle night colors"}),n.createElement(I,{checked:e.LocalStorageStore.prefersDailyChallenge,onChange:()=>e.LocalStorageStore.togglePrefDailyChallenge(),title:"Prefers Daily Challenge",desc:"Turn off to skip daily challenge"}),n.createElement(I,{checked:e.UiStore.removeTimer,onChange:()=>e.UiStore.toggleRemoveTimer(),title:"Hide Timer",desc:"If the timer bothers you, you can completely remove it from screen by selecting this option."}))})),F=s.ZP.div`
    ${$.pageCaption};
    ${$.crossButton};
    background-color: ${({theme:e})=>e.colorsUI.backgroundLight};

    .page__caption {
        background-color: ${({theme:e})=>e.colorsUI.backgroundAccent};
        color: ${({theme:e})=>e.colorsUI.textDark};
    }
    color: ${({theme:e})=>e.colorsUI.textLight};
`,O=Z,H=s.vJ`
    html {
        box-sizing: border-box;
        width: 100%;
        scroll-behavior: smooth;
    }
    *,
    *:before,
    *:after {
        box-sizing: inherit;
        transition: background-color 0.3s ease-in-out 0.1s;
        font-family: Nunito, sans-serif;
    }
    body {
        margin: 0;
        width: 100%;
        min-height: 100%;
        overflow-x: hidden;
        font-family: Nunito, sans-serif;
        font-size: 16px;
        transition: background-color 0.3s ease-in-out 0.1s;
        background-color: ${({theme:e})=>e.colorsUI.backgroundDark};
        color: ${({theme:e})=>e.colorsUI.textDark}
    }
`,z={type:"night",colorsUI:{backgroundDark:"#404040",backgroundLight:"",backgroundAccent:"#9b9a9a",backgroundButton1:"#79a6e9db",backgroundButton2:"#20c997",textDark:"#363535",textLight:"#e0e0e0"},colorsGame:{backgroundNeutral:"#e7ebf1",backgroundLight:"#404040",backgroundGood:"#bbddb0",backgroundBad:"#c5a5b4"},bp:{mobileS:"max-width: 330px",mobileM:"max-width: 400px",mobileL:"max-width: 480px",tabletS:"max-width: 600px",tabletL:"max-width: 768px",desktopXS:"max-width: 900px",desktopS:"max-width: 1080px",desktopM:"max-width: 1200px",desktopL:"max-width: 1400px"}},j={type:"day",colorsUI:{backgroundDark:"#fff",backgroundLight:"#fff",backgroundAccent:"#d2e4ee",backgroundButton1:"#5277ae30",backgroundButton2:"#def0ea",textDark:"#000",textLight:"#000"},colorsGame:{backgroundNeutral:"#e7ebf1",backgroundLight:"#fff",backgroundGood:"#bbddb0",backgroundBad:"#c5a5b4"},bp:{mobileS:"max-width: 330px",mobileM:"max-width: 400px",mobileL:"max-width: 480px",tabletS:"max-width: 600px",tabletL:"max-width: 768px",desktopXS:"max-width: 900px",desktopS:"max-width: 1080px",desktopM:"max-width: 1200px",desktopL:"max-width: 1400px"}};function V(e){return new Promise(((t,r)=>{const a=new Image;a.onload=function(){t(a)},a.onerror=a.onabort=function(){r(e)},a.src=e}))}const X=["./images/tinified/1.png","./images/tinified/2.png","./images/tinified/3.png","./images/tinified/4.png","./images/tinified/5.png","./images/tinified/6.png","./images/tinified/7.png","./images/tinified/8.png"],K=(0,i.Pi)((()=>{!function(e){const[t,r]=(0,n.useState)(!1);(0,n.useEffect)((()=>{let t=!1;return async function(){if(t)return;const a=[];for(const t of e)a.push(V(t));await Promise.all(a),t||r(!0)}(),()=>{t=!0}}),[e])}(X);const e=L();return n.createElement(q,null,n.createElement("div",{className:"hangman__container"},(e=>{switch(e){case 8:default:return n.createElement(n.Fragment,null);case 7:return n.createElement("img",{className:"hangman",src:"./images/tinified/1.png"});case 6:return n.createElement("img",{className:"hangman",src:"./images/tinified/2.png"});case 5:return n.createElement("img",{className:"hangman",src:"./images/tinified/3.png"});case 4:return n.createElement("img",{className:"hangman",src:"./images/tinified/4.png"});case 3:return n.createElement("img",{className:"hangman",src:"./images/tinified/5.png"});case 2:return n.createElement("img",{className:"hangman",src:"./images/tinified/6.png"});case 1:return n.createElement("img",{className:"hangman",src:"./images/tinified/7.png"});case 0:return n.createElement("img",{className:"hangman",src:"./images/tinified/8.png"})}})(e.remainingAttempts)))})),Y=K,q=s.ZP.div`
    width: 100%;
    background-color: #e7ebf1;
    height: 200px;

    .hangman__container {
        display: flex;
        flex-direction: column;
        margin: auto;
        width: 125px;
    }

    .hangman {
        width: 100%;
        height: auto;
        max-width: 100px;
    }

    @media screen and (min-height: 720) {
        height: 350px;
        

        .hangman__container {
            display: flex;
            flex-direction: column;
            margin: auto;
            width: 150px
        }
    }
`,J=(0,i.Pi)((()=>{const e=L();return n.createElement(ee,{onClick:()=>e.giveUp()},(e=>{switch(e){case c.Lost:return"Try Again";case c.Won:return"Play Again";case c.New:return"Reroll";case c.Playing:return"Give Up";default:return""}})(e.gameStage))})),Q=J,ee=s.ZP.div`
    background-color: white;
    border-radius: 10px;
    height: 34px;
    width: 100px;
    margin-left: 10px;
    margin-bottom: 10px;
    cursor: pointer;
    align-items: center;
    display: flex;
    text-align: center;
    justify-content: center;
    user-select: none;

    div {
        
    }
`,te=(0,i.Pi)((()=>{const e=v().GameStore.remainingAttempts;return n.createElement(re,null,"Guesses left: ",e)})),re=s.ZP.div`
    margin-bottom: 10px;
    user-select: none;
    text-align: center;
`,ae=(0,i.Pi)((()=>{const[e,t]=(0,n.useState)("00:00"),r=v().GameStore,a=v().UiStore,{gameStartAt:o,gameFinishAt:i,gameStage:s}=r;return(0,n.useEffect)((()=>{const e=setInterval((()=>{s===c.Playing?t(p(o,new Date)):s===c.Won||s===c.Lost?t(p(o,i)):s===c.New&&t("00:00")}),250);return()=>{clearInterval(e)}}),[s]),a.removeTimer?n.createElement("div",null):n.createElement(ne,null,a.timerShown&&n.createElement("div",{className:"Timer-time"},e),n.createElement("input",{alt:"timer",className:"Timer-button",type:"image",src:"images/icons/timer.svg",onClick:()=>a.showHideTimer(!a.timerShown)}))})),ne=s.ZP.div`
    background-color: white;
    border-radius: 10px;
    height: 34px;
    width: 100px;
    margin-right: 10px;
    margin-bottom: 10px;
    margin-left: auto;
    align-items: center;
    display: flex;
    text-align: center;
    justify-content: center;
    user-select: none;

    div {
        font-weight: 600;
        margin-right: 5px;
        margin-top: 3px;
    }

    input {
        display: block;
        height: 34px;
        width: 34px;
    }
`,oe=ae;function ie(){return n.createElement(se,null,n.createElement(Q,null),n.createElement(te,null),n.createElement(oe,null))}const se=s.ZP.div`
    background-color:#e7ebf1;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, calc(100%/3));
    align-items: center;
    justify-content: center;
    padding-bottom: 5px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
`;var le;!function(e){e[e.Neutral=0]="Neutral",e[e.Bad=1]="Bad",e[e.Good=2]="Good"}(le||(le={}));function ce(e){return n.createElement(ge,{onClick:()=>e.onClick(),ClueColor:e.ClueColor},e.letter)}const ge=s.ZP.div`
    margin: 3px;
    background-color: ${e=>((e,t)=>{switch(e){case le.Neutral:return t.colorsGame.backgroundNeutral;case le.Bad:return t.colorsGame.backgroundBad;case le.Good:return t.colorsGame.backgroundGood;default:return"#fff"}})(e.ClueColor,e.theme)};
    border-radius: 4px;
    min-height: 40px;
    display: flex;
    flex: 1;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: inherit;
    text-decoration: inherit;
    cursor: pointer;
    transition: background-color 0.3s ease-out 0s;
    user-select: none;
`;var de=r(952);let me;const he=(0,i.Pi)((()=>{const e=new de.Howl({src:["./audio/correctLetter.mp3"]}),t=new de.Howl({src:["./audio/wrongLetter.mp3"]}),r=v(),a=r.UiStore.locale.keyboard.map((e=>e.split(" ")));me=function(e){const t=new Set;return e.forEach((e=>{e.forEach((e=>{"Backspace"!==e&&"Enter"!==e&&t.add(e)}))})),t}(a);const o=e=>r.GameStore.goodLetters.includes(e)?le.Good:r.GameStore.badLetters.includes(e)?le.Bad:le.Neutral,i=a=>{-1===r.GameStore.playedKeys.indexOf(a)&&(r.UiStore.muteSound||(r.GameStore.isLetterGood(a)?(e.play(),r.GameStore.addPlayedKey(a)):(t.play(),r.GameStore.addPlayedKey(a)))),r.GameStore.handleLetter(a)};return(0,n.useEffect)((()=>{const e=e=>{me.has(e.key)&&i(e.key)};return document.addEventListener("keydown",e),()=>{document.removeEventListener("keydown",e)}}),[]),n.createElement(pe,{"aria-hidden":"true"},a.map(((e,t)=>n.createElement("div",{key:t,className:"keyboard__row"},e.map(((e,t)=>{const a=e.toLocaleUpperCase(r.UiStore.lang);return n.createElement(ce,{key:t,onClick:()=>i(e),letter:a,ClueColor:o(e)})}))))))})),ue=he,pe=s.ZP.div`
    
display: flex;
flex-direction: column;
max-width: 720px;
margin: 0 auto;


.keyboard__row {
    display: flex;
    flex-direction: row;
    justify-content: stretch;
}

`;function fe(e){const[t,r]=(0,n.useState)(!1),{letter:a,isShown:o,size:i}=e;return(0,n.useEffect)((()=>{o&&r(!0)}),[]),n.createElement(be,{size:i,isShown:o,isFlipped:t},n.createElement("div",null,o?a:""))}const xe=s.F4`
    0% {
        transform: rotateX(0);
    }
    25% {
        transform: rotateX(90deg);
    }
    50% {
        transform: rotateX(180deg);
    }
    75% {
        transform: rotateX(270deg);
    }
    100% {
        transform: rotateX(360deg);
    }
`,be=s.ZP.div`
    display: flex;
    text-align: center;
    justify-content: center;
    align-items: center;
    width: ${({size:e})=>`min(${e}, 55px)`};
    height: ${({size:e})=>`min(${e}, 55px)`};
    margin-right: 0.2rem;
    font-size: 2em;
    border-radius: 5px;
    text-transform: uppercase;
    font-weight: bold;
    text-align: center;
    line-height: 90px;
    background-color: ${e=>e.isShown?e.theme.colorsGame.backgroundGood:e.theme.colorsGame.backgroundNeutral};
    transition: color 1s ease-in-out 0.2s;
    animation-name: ${e=>{return t=e.isShown,r=e.isFlipped,t&&!r?xe:"none";var t,r}};
    animation-duration: 0.5s;
    animation-timing-function: linear;
    animation-iteration-count: 1;

    
`,we=(0,i.Pi)((()=>{const e=L(),t=e.hiddenWord.split(""),r=e.goodLetters,a=e=>`${720/e}px`;return n.createElement(ye,{size:a(t.length)},t.map(((e,o)=>n.createElement(fe,{size:a(t.length),key:o,letter:e,isShown:r.includes(e)}))))})),ye=s.ZP.div`
    display: flex;
    margin: 0;
    height: 70px;
    align-items: center;
    justify-content: center;
`;function Se(){return n.createElement(n.Fragment,null,n.createElement(Y,null),n.createElement(ie,null),n.createElement(we,null),n.createElement(ue,null))}function ke(e){return n.createElement(ve,null,n.createElement("div",{className:"stat__value"},e.value),n.createElement("div",{className:"stat__desc"},e.description))}const ve=s.ZP.div`
    text-align: center;
    background: #f5f7fb;
    padding: 7px;
    border-radius: 8px;
    min-height: 88px;

    .stat__value {
        font-size: 42px;
        font-weight: 700;
    }

    .stat__desc {
        color: #818692;
        font-size: 11px;
        text-transform: uppercase;
        line-height: 16px;
    }
`;function Ee(){const e=E(),t=function(){const{LocalStorageStore:e}=v();return e}();return n.createElement(Le,null,n.createElement("div",{className:"page__caption"},"Statistics",n.createElement("button",{className:"crossbutton",onClick:()=>e.togglePage(a.Game)})),n.createElement("div",{className:"center"},n.createElement("div",{className:"statistics__container"},n.createElement(ke,{description:"🏆 Games Won",value:t.getTotalWins}),n.createElement(ke,{description:"😿 Games Lost",value:t.getTotalLosses}),n.createElement(ke,{description:"✅ Correct Guesses",value:t.getTotalGoodGuesses}),n.createElement(ke,{description:"❌ Incorrect Guesses",value:t.getTotalBadGuesses}),n.createElement(ke,{description:"👌 Perfect Games",value:t.getTotalPerfectGames}),n.createElement(ke,{description:"📆 Daily Challenges Completed",value:t.getTotalDailyWins}))))}const Le=s.ZP.div`
  ${$.pageCaption};
  ${$.crossButton};
  background-color: ${({theme:e})=>e.colorsUI.backgroundLight};

  .page__caption {
        background-color: ${({theme:e})=>e.colorsUI.backgroundAccent};
    }

    .center {
        max-width: 550px;
        margin: 0 auto;
    }
    
    .statistics__container {
        margin-top: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        column-gap: 10px;
        row-gap: 10px;
    }
`;function Ce(){const[e,t]=(0,n.useState)(""),[r,o]=(0,n.useState)(!1);let i;const s=E();return n.createElement(_e,null,n.createElement("div",{className:"page__caption"},"Generator",n.createElement("button",{className:"crossbutton",onClick:()=>s.togglePage(a.Game)})),n.createElement("div",{className:"caption-secondary"},"Challenge a friend with any word"),n.createElement("div",{className:"center"},n.createElement("input",{type:"text",placeholder:"Your word ...",maxLength:20,className:"generator__input",value:e,onInput:e=>(e=>{let r=e.target.value.split("").filter((e=>" "===e||e.toLowerCase()!==e.toUpperCase())).join("").trimStart();r=r.replace(/\s+/g," "),t(r)})(e)}),r?n.createElement("div",{className:"popup"},"Link copied"):n.createElement("div",{className:"popup"}),n.createElement("button",{className:"button-default",onClick:()=>(()=>{if(0===e.length)return;const t=`${new URL(window.location.toString()).origin}?challenge=${h(e.toLowerCase())}`;navigator.clipboard.writeText(t),i&&clearTimeout(i),o(!0),i=setTimeout((()=>{o(!1)}),3e3)})()},"Copy link")))}const _e=s.ZP.div`
    ${$.pageCaption};
    ${$.crossButton};
    ${$.defaultButton};
    background-color: ${({theme:e})=>e.colorsUI.backgroundLight};

    .page__caption {
        background-color: ${({theme:e})=>e.colorsUI.backgroundAccent};
    }

    .caption-secondary {
        font-size: 24px;
        text-align: center;
        margin: 10px 0 10px 0;
        color: ${({theme:e})=>e.colorsUI.textLight};
    }

    .popup {
        height: 1rem;
        text-align: center;
        margin: 10px 0px 10px 0px;
        color: ${({theme:e})=>e.colorsUI.textLight};

    }

    .center {
        max-width: 300px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        flex-direction: column;
    }
    
    .generator__input {
        min-height: 44px;
        border-radius: 5px;
        border: 1px solid #a3a3a3;
        padding: 0px 15px 0px 15px;
        margin: 0px 0px 10px 0px;
        max-width: 20rem;
        font-size: 18px;
    }

    .button-default {
        background-color: ${({theme:e})=>e.colorsUI.backgroundButton2};
    }

    .button-default:hover {
        color: #626568;
        background: ${({theme:e})=>e.colorsUI.backgroundButton1};
    }

    .button-default:disabled {
        background-color: #3e485730;
        color: #8c8e91;
    }
`;function Te(){const e=E();return n.createElement(Pe,null,n.createElement("div",{className:"page__caption"},"About",n.createElement("button",{className:"crossbutton",onClick:()=>e.togglePage(a.Game)})))}const Pe=s.ZP.div`
    ${$.pageCaption};
    ${$.crossButton};
    background-color: ${({theme:e})=>e.colorsUI.backgroundLight};

    .page__caption {
        background-color: ${({theme:e})=>e.colorsUI.backgroundAccent};
    }
`,Ge=e=>`${new URL(window.location.toString()).origin}?challenge=${h(e.toLowerCase())}`;const Ne=(0,i.Pi)((()=>{const e=v(),[t,r]=(0,n.useState)(!1),[a,o]=(0,n.useState)(!1),i=new de.Howl({src:["./audio/win.mp3"]}),s=new de.Howl({src:["./audio/loss.mp3"]});let g;let d;const m=()=>{navigator.clipboard.writeText(Ge(e.GameStore.hiddenWord)),d&&clearTimeout(d),o(!0),d=setTimeout((()=>{o(!1)}),3e3)};return(0,n.useEffect)((()=>{r(!1),g&&clearTimeout(g),g=setTimeout((()=>{r(!0)}),500)}),[]),n.createElement(Ae,null,t?n.createElement(Me,null,void(e.UiStore.muteSound||(e.GameStore.gameStage===c.Won?i.play():s.play())),n.createElement("div",{className:"result__title"},e.GameStore.gameStage===c.Won?"You have won":"You have lost",n.createElement("button",{className:"crossbutton",onClick:()=>e.UiStore.toggleModal(l.None)})),n.createElement("div",{className:"result__content"},n.createElement("div",{className:"content"},n.createElement("span",null,e.GameStore.gameStage===c.Won?"You have guessed the word":"The answer was"),n.createElement("div",{className:"content__answer"},e.GameStore.hiddenWord),n.createElement("span",null,e.GameStore.gameStage===c.Won?`It took you ${(()=>{let t=e.GameStore.gameFinishAt.getTime()-e.GameStore.gameStartAt.getTime();return t/=1e3,t=Math.round(t),t.toString()})()} seconds!`:"Better luck next time"),n.createElement("button",{className:"button-default",onClick:()=>{e.GameStore.gameReset(),e.UiStore.toggleModal(l.None)}},"Play again"),n.createElement("button",{className:"button-default",onClick:()=>m()},a?"Link copied to clipboard":"Challenge a friend to this word"),(h="try it",u=Ge(e.GameStore.hiddenWord),n.createElement("p",{key:p,className:"Share-icons-bar"},n.createElement("a",{href:"http://www.twitter.com/share?text="+h+"&url="+u,target:"_blank",rel:"noopener noreferrer"},n.createElement("img",{className:"Share-icon",src:"images/twitter.svg"})),n.createElement("a",{href:"https://reddit.com/submit?title="+h+"&url="+u,target:"_blank",rel:"noopener noreferrer"},n.createElement("img",{className:"Share-icon",src:"images/reddit.svg"})),n.createElement("a",{href:"https://www.facebook.com/sharer/sharer.php?u="+u,target:"_blank",rel:"noopener noreferrer"},n.createElement("img",{className:"Share-icon",src:"images/facebook.svg"})),n.createElement("a",{href:"fb-messenger://share/?link="+u,target:"_blank",rel:"noopener noreferrer"},n.createElement("img",{className:"Share-icon",src:"images/facebook-messenger.svg"})),n.createElement("a",{href:"https://snapchat.com/scan?attachmentUrl="+u,target:"_blank",rel:"noopener noreferrer"},n.createElement("img",{className:"Share-icon",src:"images/snapchat.svg"})),n.createElement("a",{href:"https://api.whatsapp.com/send?text="+u,target:"_blank",rel:"noopener noreferrer"},n.createElement("img",{className:"Share-icon",src:"images/whatsapp.svg"})))),n.createElement("div",{className:"ad__container"})))):n.createElement(n.Fragment,null));var h,u,p})),De=Ne,Ue=s.F4`
    from {
        opacity: 0;
        transform: scale(0);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
`,Ae=s.ZP.div`
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
`,Me=s.ZP.div`
    display: flex;
    flex-direction: column;
    margin: 86px 5px 0px 5px;
    width: 380px;
    border-radius: 5px;
    overflow: auto;
    background-color: white;
    box-shadow: 0 0 0 0 rgb(255 255 255 / 50%), 0 0 40px rgb(0 0 0 / 80%);
    user-select: none;
    animation-name: ${Ue};
    animation-duration: 0.8s;

    ${$.defaultButton};

    .button-default {
        background-color: ${({theme:e})=>e.colorsUI.backgroundButton2};
    }

    .button-default:hover {
        color: #626568;
        background: ${({theme:e})=>e.colorsUI.backgroundButton1};
    }

    .button-default:disabled {
        background-color: #3e485730;
        color: #8c8e91;
    }

    .result__title {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
        padding: 5px;
        border-radius: 5px 5px 0 0;
        background-color: #f1f3f9;
        font-size: 24px;
        font-weight: 800;
        flex-grow: 1;
        ${$.crossButton};
    }
    
    .result__content {
        padding: 5px 20px 5px 20px;
        width: 100%;
        height: 100%;
    }

    .content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        span {
            margin: 10px;
            font-size: 24px;
        }
    }

    .content__answer {
        display: inline-block;
        margin: 5px;
        padding: 10px 15px;
        font-size: 18px;
        text-transform: uppercase;
        vertical-align: top;
        border-radius: 5px;
        background: #f1f3f9;
        border: 1px dashed #75819e;
    }

    .Share-icon {
        height: 45px;
    }

    .Share-icons-bar {
        margin: 5px;
    }
`,$e=(0,i.Pi)((()=>{const e=E();return n.createElement(Re,null,(()=>{switch(e.currentModal){case l.None:return n.createElement(n.Fragment,null);case l.GameResult:return n.createElement(De,null);default:return n.createElement(n.Fragment,null)}})())})),Re=s.ZP.div`
    z-index: 1000;
    position: relative;
`,We=$e;function Be(e){return n.createElement(Ie,{onClick:()=>e.onClick()},e.children)}const Ie=s.ZP.div`
    text-align: center;
    background-color: ${({theme:e})=>e.colorsUI.backgroundAccent};
    font-size: 20px;
    border-radius: 6px;
    padding: 6px;
    cursor: pointer;
    user-select: none;
`;function Ze(){const e=v();return n.createElement(Fe,null,n.createElement("div",{className:"page__caption"},"Category",n.createElement("button",{className:"crossbutton",onClick:()=>e.UiStore.togglePage(a.Game)})),n.createElement("div",{className:"center"},n.createElement("div",{className:"categories__container"},["Easy","Medium","Hard","Random"].map(((t,r)=>n.createElement(Be,{onClick:()=>e.GameStore.changeCategory(t),key:r},t))))))}const Fe=s.ZP.div`
    ${$.pageCaption};
    ${$.crossButton};
    background-color: ${({theme:e})=>e.colorsUI.backgroundLight};
    padding-bottom: 20px;

    .page__caption {
        background-color: ${({theme:e})=>e.colorsUI.backgroundAccent};
    }

    .center {
        max-width: 550px;
        margin: 0 auto;
    }
    
    .categories__container {
        margin-top: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        column-gap: 10px;
        row-gap: 10px;
    }

`,Oe=(0,i.Pi)((()=>{const e=v();return(0,n.useEffect)((()=>{e.GameStore.loadAssets()}),[]),(0,n.useEffect)((()=>{document.body.className=e.UiStore.darkTheme?"dark":"",setTimeout((()=>{document.body.style.transition="0.3s background-color ease-out"}),1)}),[e.UiStore.darkTheme]),n.createElement(s.f6,{theme:e.UiStore.darkTheme?z:j},n.createElement(H,null),n.createElement(We,null),n.createElement(ze,null,n.createElement(A,null),(()=>{switch(e.UiStore.displayPage){case a.Game:return n.createElement(Se,null);case a.Editor:return n.createElement(Ce,null);case a.About:return n.createElement(Te,null);case a.Settings:return n.createElement(O,null);case a.Statistics:return n.createElement(Ee,null);case a.Category:return n.createElement(Ze,null)}})()))})),He=Oe,ze=s.ZP.div`
  max-width: 720px;
  margin: 0 auto;
`;o.render(n.createElement(n.StrictMode,null,n.createElement((function({children:e}){const t=new S;return n.createElement(k.Provider,{value:t},e)}),null,n.createElement(He,null))),document.getElementById("root"))}},r={};function a(e){var n=r[e];if(void 0!==n)return n.exports;var o=r[e]={exports:{}};return t[e](o,o.exports,a),o.exports}a.m=t,e=[],a.O=(t,r,n,o)=>{if(!r){var i=1/0;for(g=0;g<e.length;g++){for(var[r,n,o]=e[g],s=!0,l=0;l<r.length;l++)(!1&o||i>=o)&&Object.keys(a.O).every((e=>a.O[e](r[l])))?r.splice(l--,1):(s=!1,o<i&&(i=o));if(s){e.splice(g--,1);var c=n();void 0!==c&&(t=c)}}return t}o=o||0;for(var g=e.length;g>0&&e[g-1][2]>o;g--)e[g]=e[g-1];e[g]=[r,n,o]},a.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return a.d(t,{a:t}),t},a.d=(e,t)=>{for(var r in t)a.o(t,r)&&!a.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},a.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),a.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={179:0};a.O.j=t=>0===e[t];var t=(t,r)=>{var n,o,[i,s,l]=r,c=0;if(i.some((t=>0!==e[t]))){for(n in s)a.o(s,n)&&(a.m[n]=s[n]);if(l)var g=l(a)}for(t&&t(r);c<i.length;c++)o=i[c],a.o(e,o)&&e[o]&&e[o][0](),e[o]=0;return a.O(g)},r=self.webpackChunkreact_hangman=self.webpackChunkreact_hangman||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))})();var n=a.O(void 0,[496],(()=>a(50)));n=a.O(n)})();