const $btnViber = document.querySelector('.viber')
const $btnTelegram = document.querySelector('.telegram')
const $becomeTrader = document.querySelector('.header__link')

function btnAnimate(delay, btn) {
    setTimeout(() => {
        btn.classList.add('animate__animated', 'animate__shakeY')
        setInterval(() => {
            btn.classList.add('animate__animated', 'animate__shakeY')
            setTimeout(() => {
                btn.classList.remove('animate__animated', 'animate__shakeY')
            }, 1500)
        }, 3000)
    }, delay)
}

btnAnimate(3400, $btnViber)
btnAnimate(5000, $btnTelegram)

let heightOfWindow = window.innerHeight
//let isChrome = navigator.userAgent.search(/Chrome/) > 0
//if (isChrome) {
//    heightOfWindow = window.innerHeight - 56 
//}
document.querySelector('#app').style.height = heightOfWindow + 'px'

const userAgent = navigator.userAgent.toLowerCase() 
const Safari = navigator.userAgent.indexOf("Chrome") == -1 && navigator.userAgent.indexOf("Safari") != -1
const isIphone = /iphone/.test(userAgent)

if (Safari && isIphone) {
 document.querySelector('.footer').classList.add('iphone')
}

//analityx
$btnViber.addEventListener('click', () => {
    gtag('event', 'conversion', {
        'send_to': 'AW-1014065210/-xIBCNuQ1NQBELrQxeMD',
    })
})
$btnTelegram.addEventListener('click', () => {
    gtag('event', 'conversion', {
        'send_to': 'AW-1014065210/zwP0CImV1NQBELrQxeMD',
    })
})
$becomeTrader.addEventListener('click', () => {
    gtag('event', 'conversion', {
        'send_to': 'AW-1014065210/DRp6CN6W1NQBELrQxeMD',
    })
})
