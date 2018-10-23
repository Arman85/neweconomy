function openTab( evt, tabName ){
	
	var i, tabcontent, tablinks;

	// Получаю все элементы с классом tabcontent и прячу их
	tabcontent = document.getElementsByClassName('tabcontent');
	
	for ( i = 0; i < tabcontent.length; i++ ){
		tabcontent[i].style.display = "none";
	}

	// Получаю все элементы с классом tablinks и удаляю класс active
	tablinks = document.getElementsByClassName("tablinks");

	for ( i = 0; i < tablinks.length; i++ ){
		tablinks[i].className = tablinks[i].className.replace("active", "");
	}

	// Показываю текущую вкладку, и добавляю класс active кнопке которая открыла вкладку.
	document.getElementById(tabName).style.display = "block";

	evt.currentTarget.className += " active";

}