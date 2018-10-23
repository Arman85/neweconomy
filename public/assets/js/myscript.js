function openTab( evt, tabName ){
	
	var i, tabcontent, tablinks;

	// Get all elements with class="tabcontent" and hide them
	// Получаю все элементы с классом tabcontent и прячу их
	tabcontent = document.getElementsByClassName('tabcontent');
	
	for ( i = 0; i < tabcontent.length; i++ ){
		tabcontent[i].style.display = "none";
	}

	// Get all elements with class="tablinks" and remove the class "active"
	// Получаю все элементы с классом tablinks и удаляю класс active
	tablinks = document.getElementsByClassName("tablinks");

	for ( i = 0; i < tablinks.length; i++ ){
		tablinks[i].className = tablinks[i].className.replace("active", "");
	}

	// Show the current tab, and add an "active" class to the button that opened the tab
	// Показываю текущую вкладку, и добавляю класс active кнопке которая открыла вкладку.
	document.getElementById(tabName).style.display = "block";

	evt.currentTarget.className += " active";

}