/* Atelier Benji — scripts du thème. */

document.addEventListener( 'DOMContentLoaded', function () {
	var toggle = document.querySelector( '.nav-toggle' );
	var nav = document.getElementById( 'site-nav' );

	if ( ! toggle || ! nav ) {
		return;
	}

	toggle.addEventListener( 'click', function () {
		var isOpen = nav.classList.toggle( 'is-open' );
		toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
	} );

	nav.querySelectorAll( 'a' ).forEach( function ( link ) {
		link.addEventListener( 'click', function () {
			nav.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
		} );
	} );
} );

document.addEventListener( 'DOMContentLoaded', function () {
	var MAX_COLORS = 4;

	document.querySelectorAll( '.atelier-benji-color-grid' ).forEach( function ( grid ) {
		var checkboxes = grid.querySelectorAll( '.atelier-benji-color-checkbox' );

		function update() {
			var checkedCount = grid.querySelectorAll( '.atelier-benji-color-checkbox:checked' ).length;
			checkboxes.forEach( function ( checkbox ) {
				if ( ! checkbox.checked ) {
					checkbox.disabled = checkedCount >= MAX_COLORS;
				}
			} );
		}

		checkboxes.forEach( function ( checkbox ) {
			checkbox.addEventListener( 'change', update );
		} );

		update();
	} );
} );

document.addEventListener( 'DOMContentLoaded', function () {
	var prenomSelect = document.getElementById( 'atelier_benji_prenom_taille' );
	var textInput = document.getElementById( 'atelier_benji_text' );
	var textField = textInput ? textInput.closest( '.form-field' ) : null;

	if ( ! prenomSelect || ! textField ) {
		return;
	}

	function updateTextVisibility() {
		var show = '' !== prenomSelect.value;
		textField.style.display = show ? '' : 'none';
		textInput.required = show;
	}

	prenomSelect.addEventListener( 'change', updateTextVisibility );
	updateTextVisibility();
} );
