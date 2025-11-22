import './bootstrap';
import './dashboardChart';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

if (
	localStorage.theme === 'dark' ||
	(!('theme' in localStorage) &&
		window.matchMedia('(prefers-color-scheme: dark)').matches)
	) {
	document.documentElement.classList.add('dark');
} else {
	document.documentElement.classList.remove('dark');
}

Alpine.start();

function applyOnlyNumber(selector = '.only-number') {
	const inputs = document.querySelectorAll(selector);
	//console.log('applyOnlyNumber aktif, ketemu', inputs.length, 'input');

	inputs.forEach(input => {
		input.addEventListener('input', function () {
			this.value = this.value.replace(/\D/g, '');
		});
	});
}

document.addEventListener('DOMContentLoaded', () => {
	applyOnlyNumber();
});

function applyNumberRestriction(selector = '.only-number-16', maxLength = 16) {
	const inputs = document.querySelectorAll(selector);
	inputs.forEach(input => {
		input.addEventListener('input', function () {
        let val = this.value.replace(/\D/g, ''); // hanya angka
        if (val.length > maxLength) val = val.slice(0, maxLength); // batasi panjang
        this.value = val;
    });
	});
}

document.addEventListener('DOMContentLoaded', () => {
	applyNumberRestriction();
});

function applyUppercaseRestriction(selector = '.only-uppercase', maxLength = null) {
	const inputs = document.querySelectorAll(selector);

	inputs.forEach(input => {
		input.addEventListener('input', function () {
        // Hanya izinkan huruf (A-Z/a-z)
			let val = this.value.replace(/[^a-zA-Z\s]/g, '');
        // Ubah ke huruf kapital semua
			val = val.toUpperCase();
        // Batasi panjang jika diatur
			if (maxLength && val.length > maxLength) val = val.slice(0, maxLength);
        // Set kembali ke input
			this.value = val;
		});
	});
}

document.addEventListener('DOMContentLoaded', () => {
	applyUppercaseRestriction();
});
