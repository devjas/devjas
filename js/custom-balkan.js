let diff_price = document.getElementsByName('different_price')[0];
let price_for_all = document.getElementsByName('price_for_all_ages')[0];
let ca_price = document.getElementsByClassName('ca-price')[0];
let cAgeRange = document.getElementById('cAgeRange');
let ca_price_label = document.getElementsByClassName('children-price-label')[0];
let children_price_class = document.getElementsByClassName('children-price')[0];
let adult_price = document.getElementsByName('adult_price')[0];
let children_price = document.getElementsByName('children_price')[0];
if(diff_price) {
	if(diff_price.checked) {
		ca_price.classList.add('show-flexbox');
		price_for_all.setAttribute('disabled', true);
	}
}
if(cAgeRange) {
	let car_text = cAgeRange.options[cAgeRange.selectedIndex].textContent.toUpperCase();
	let car_value = cAgeRange.options[cAgeRange.selectedIndex].value;
	let opt = Array.from(cAgeRange);
	let selected = opt.filter(options => {
		return options.selected;
	});
	if(selected) {
		if(car_value != 0) {
			children_price_class.classList.add('show-flexbox');
			ca_price_label.textContent = car_text + ' PRICE';
		} else {
			children_price.value = null;
			children_price_class.classList.add('show-flexbox');
			children_price_class.classList.add('hide-flexbox');
			setTimeout(function() {
				children_price_class.classList.remove('show-flexbox');
				children_price_class.classList.remove('hide-flexbox');
			}, 200);
		}
	}
}
if(adult_price.value !== '') {
	ca_price.classList.add('show-flexbox');
	diff_price.checked = true;
}
let i = 0;
class Price {
	diffPrice(event) {
		if(event.checked) {
			localStorage.setItem('priceForAll', price_for_all.value);
			price_for_all.value = null;
			price_for_all.setAttribute('disabled', true);
			ca_price.classList.add('show-flexbox');
			adult_price.value = localStorage.getItem('adultPrice');
			children_price.value = localStorage.getItem('childrenPrice');
			localStorage.removeItem('adultPrice');
			localStorage.removeItem('childrenPrice');
		} else {
			localStorage.setItem('adultPrice', adult_price.value);
			localStorage.setItem('childrenPrice', children_price.value);
			price_for_all.value = localStorage.getItem('priceForAll');
			price_for_all.removeAttribute('disabled');
			price_for_all.focus();
			adult_price.value = null;
			children_price.value = null;
			ca_price.classList.add('hide-flexbox');
			setTimeout(function() {
				ca_price.classList.remove('show-flexbox');
				ca_price.classList.remove('hide-flexbox');
			}, 200);
			localStorage.removeItem('priceForAll');
		}
	}
	childrenPriceRange(event) {
		let car_text = cAgeRange.options[cAgeRange.selectedIndex].textContent.toUpperCase();
		let car_value = cAgeRange.options[cAgeRange.selectedIndex].value;		
		ca_price_label.textContent = car_text + ' PRICE';
		if(car_value != 0) {
			children_price_class.classList.add('show-flexbox');
		} else {
			children_price.value = null;
			children_price_class.classList.add('show-flexbox');
			children_price_class.classList.add('hide-flexbox');
			setTimeout(function() {
				children_price_class.classList.remove('show-flexbox');
				children_price_class.classList.remove('hide-flexbox');
			}, 200);
		}
	}
	samePriceModal() {
		price_for_all.value = adult_price.value;
		diff_price.checked = false;
		if(!diff_price.checked) {
			price_for_all.removeAttribute('disabled');
			adult_price.value = null;
			children_price.value = null;
			ca_price.classList.add('hide-flexbox');
			setTimeout(function() {
				ca_price.classList.remove('show-flexbox');
				ca_price.classList.remove('hide-flexbox');
			}, 200);
		}
	}
	aPrice(event) {
		if(event) {
			let event_value = event.split('.').join('')
			let cp_value = children_price.value.split('.').join('');
			// console.log(parseFloat(event_value));
			if(parseFloat(cp_value) == parseFloat(event_value)) {
				$('#forAllAgesModal').modal('show');
				this.enteredPrice();
			}
		}
	}
	cPrice(event) {
		if(event) {
			let event_value = event.split('.').join('')
			let ap_value = adult_price.value.split('.').join('');
			// console.log(parseFloat(event_value))
			if(parseFloat(ap_value) == parseFloat(event_value)) {
				$('#forAllAgesModal').modal('show');
				this.enteredPrice();
			}
		}
	}
	enteredPrice() {
		document.getElementById('enteredPrice').textContent = adult_price.value;
	}

}
const price = new Price;
