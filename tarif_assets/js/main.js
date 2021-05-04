function setElemHeight() {
    let clientHeight = document.documentElement.clientHeight
    const $blueBg = document.querySelector('.siteIsUnaviable')
    if (window.innerWidth <= 320) {
        clientHeight = clientHeight - 50
    } else if (window.innerWidth < 360) {
        clientHeight = clientHeight - 60
    } else if (window.innerWidth <= 991) {
        clientHeight = clientHeight - 80
    }
    $blueBg.style.height = clientHeight + 'px' 
}

function initAnimationsDelay () {
    const $elemsToAnimate = document.querySelectorAll('.animate__animated')
    $elemsToAnimate.forEach($el => {
        const delay = $el.dataset.delay
        $el.style.animationDelay = delay
    })
}
window.addEventListener('resize', setElemHeight)
window.onload = () => {
    setElemHeight()
    initAnimationsDelay()
}