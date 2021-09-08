$(function(){
    $('.select-tags').select2({
        tags: true
    }).on('change', function(e) {
        let label = $(this).find("[data-select2-tag=true]");
        if(label.length && $.inArray(label.val(), $(this).val() !== -1)) {
            $.ajax({
                url: "/tags/add/ajax/"+label.val(),
                type: "POST"
            }).done(function(data) {
                label.replaceWith(`<option selected value="${data.id}">${label.val()}</option>`);
            })
        }
    });
})