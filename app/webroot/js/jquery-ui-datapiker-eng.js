$(function() {

    $(".datepicker").datepicker({
        dayNames : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        dayNamesMin : ['S', 'M', 'T', 'W', 'T', 'F', 'S', 'S'],
        dayNamesShort : ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
        monthNames : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthNamesShort : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        nextText : 'Next',
        prevText : 'Previous',
        changeMonth : true,
        changeYear : true,
        closeText : 'Done',
        currentText : 'This month',
        showButtonPanel : true,
         dateFormat : 'yy-mm-dd',
        onChangeMonthYear : function(year, month, inst) {

            $(this).attr('value', month + "-" + year);

        }
    });

});

$(function() {
    $(".data_datepicker").datepicker({
        dayNames : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        dayNamesMin : ['S', 'M', 'T', 'W', 'T', 'F', 'S', 'S'],
        dayNamesShort : ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
        monthNames : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthNamesShort : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        nextText : 'Next',
        prevText : 'Previous',
        changeMonth : true,
        changeYear : true,
        closeText : 'Done',
        currentText : 'This month',
        showButtonPanel : true,
        dateFormat : 'yy-mm-dd',

    });
}); 