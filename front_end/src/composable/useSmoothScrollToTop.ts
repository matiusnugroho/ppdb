export function useSmoothScrollToTop() {
	const smoothScrollToTop = (selector: string, options?: ScrollToOptions) => {
		console.log({ selector, options })
		try {
			const container = document.querySelector(selector) as HTMLElement

			if (container) {
				const defaultOptions: ScrollToOptions = {
					top: 0,
					behavior: "smooth",
					...options,
				}

				container.scrollTo(defaultOptions)
				window.scrollTo({ top: 0, behavior: "smooth" })
			} else {
				console.warn(`Element with selector ${selector} not found.`)
			}
		} catch (error) {
			console.error("Error in smoothScrollToTop:", error)
		}
	}

	return {
		smoothScrollToTop,
	}
}
