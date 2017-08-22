;(function($){
    for(i in stc.counter){
        var tax = stc.counter[i];
        $("tbody#the-list").find("td:contains(" + tax.name + ")")
            .parent().find("td.column-posts a").text(tax.counter);

        /*if(0!=tax.counter) {
            $("tbody#the-list").find("td:contains(" + tax.name + ")")
                .parent().find("td.column-posts a").text(tax.counter);
        }else{
            $("tbody#the-list").find("td:contains(" + tax.name + ")").parent().remove();
        }*/
    }
})(jQuery);

