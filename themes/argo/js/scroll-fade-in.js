let callback = (entries, observer) => {
  entries.forEach(entry => {
		if(entry.isIntersecting) {
			// console.log("Intersecting: " + entry.target.innerHTML)
			entry.target.classList.remove('scroll-hidden')
		} else {
			// console.log("not intersect: " + entry.target.innerHTML)
			// entry.target.classList.add('scroll-hidden')
		}
  });
};

let observer = new IntersectionObserver(callback, {
	// root: document.querySelector('body'),
  rootMargin: '0px',
  threshold: .2
});


document.querySelectorAll('.landing-body h1, .landing-body p, .page-team figure,[data-slide-in]').forEach(el=>{
	el.classList.add('scroll-hidden')
	el.classList.add('scroll-hideable')

	observer.observe(el);
})