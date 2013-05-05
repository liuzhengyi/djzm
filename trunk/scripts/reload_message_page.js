function get_reload_url(base_url, suffix) {
	var message_head = document.getElementById('input_head').value;
	var message_content = document.getElementById('input_content').value;
	var message_author = document.getElementById('input_author').value;
	var message_contact = document.getElementById('input_contact').value;

	var full_url = base_url + '?message_head='+ message_head + '&message_content='+message_content+'&message_author='+message_author+'&message_contact='+message_contact+suffix;
	//alert(full_url);
	window.location.href = full_url;
}
