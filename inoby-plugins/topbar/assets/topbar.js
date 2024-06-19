function Marquee(selector, speed) {
  const parentSelector = document.querySelector(selector);
  const clone = parentSelector.innerHTML;
  const firstElement = parentSelector.children[0];
  let i = 0;
  parentSelector.insertAdjacentHTML('beforeend', clone);

  setInterval(function () {
    firstElement.style.marginLeft = `-${i}px`;
    if (i > 1320) {
      i = 0;
    }
    i = i + speed;
  }, 0);
}

window.addEventListener('load', Marquee('.js-marquee', 0.2))
