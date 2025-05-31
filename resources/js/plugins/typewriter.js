// resources/js/components/typewriter.js
export function typewriter(strings) {
    return {
        text: '',
        index: 0,
        charIndex: 0,
        isDeleting: false,
        start() {
            this.type();
        },
        type() {
            const current = strings[this.index];
            if (this.isDeleting) {
                this.text = current.substring(0, this.charIndex--);
            } else {
                this.text = current.substring(0, this.charIndex++);
            }

            if (!this.isDeleting && this.charIndex === current.length) {
                setTimeout(() => this.isDeleting = true, 1000);
            } else if (this.isDeleting && this.charIndex === 0) {
                this.isDeleting = false;
                this.index = (this.index + 1) % strings.length;
            }

            setTimeout(() => this.type(), 100);
        }
    };
}
