$(document).ready(function() {
    $('#search_form').on('submit', function(event) {
        event.preventDefault();

        let search_text = $("#search_text").val()

        $('#results').empty();
        if (search_text.length >= 3) {
            searchPost(search_text);
        }
    });

    function searchPost(search_text) {
        $.ajax({
            url: "/search",
            data: {
                search_text: search_text
            },
            success: function(response) {
                response.forEach(element => {
                    $('#results').append("<div><h3>" + element.title + "</h3><p>" + element.body + "</p></div><hr>");
                });

            }
        });
    }
});