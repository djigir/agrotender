// REPLACEMENT START
function replacerWithSpaces(text) {
  return text.replace(/\B(?=(\d{3})+(?!\d))/g, " ")
}

function replaceWithSpacesAllItems () {
  const replaceItems = document.querySelectorAll('.replace_numbers_js')
  Array.prototype.slice.call(replaceItems).forEach(item => {
    item.textContent =  replacerWithSpaces(item.textContent)
  })
}

const replaceItem = document.querySelector('.replace_numbers_js')

if (replaceItem) {
  replaceWithSpacesAllItems()
}
  