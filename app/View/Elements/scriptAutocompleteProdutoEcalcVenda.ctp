              <script type="text/javascript">
  $(document)
 .ready(
    function() {

var MaxInputs = 8; //maximum input boxes allowed
var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
var AddButton = $("#AddMoreFileBox"); //Add button ID

var x = InputsWrapper.length; //initlal text box count
if (x == 0) {
x = 1;
}
var FieldCount = 0; //to keep track of text box added

$(AddButton)
.click(
        function(e) //on add input button click
        {
            if (true) //max input box allowed
            {
                FieldCount++; //text box added increment
                //add input box
                $(InputsWrapper)
                .append(
                    '<div class="control-group"><label class="control-label"><?php echo __("Produto") ?> :</label><div class="controls"><input type="text" disabled="disabled"   class="span5"  id="produto_'+ FieldCount+'"  /> <span style="margin-left: 2%;"> <?php echo __('Preço') ?> : <input type="text" disabled="disabled"   id="preco_'+ FieldCount+'" value=" '+ FieldCount +'" class="span2"  /></span> <span style="margin-left: 2%;"> <?php echo __('Qtd')?> : <input required="true" type="number" autocomplete="off" class="span1" min="1" name="data[Produto]['+FieldCount+'][pro_quantidade]" onChange="recalc();" id="quantidade_'
                    + FieldCount
                    + '" value="'
                    + 1
                    + '"   /></span><span style="margin-left:1%" class="removeclass" ><a href="#" class="btn btn-danger btn-mini" > <?php echo __('Remover produto') ?> </a><span><span style="color: green; margin-left: 1%; font-size: 15px" id="total_item_'
                    + FieldCount
                    + '">R$'
                    + 1
                    + '.00</span><input value="" id="idProduto_'+ FieldCount+'" type="hidden"name="data[Produto]['+FieldCount+'][id]" /></div>');
                x++; //text box increment
                recalc();

            }
            return false;
        });
        
     
      


    $("body").on("click",".removeclass",
        function(e) { //user click on remove text
            if (x > 1) {
                $( this).parents('div.control-group').remove(); //remove text box

                x--; //decrement textbox

                recalc();
            }
            return false;
        })

$("#produto").autocomplete({
    width : 300,
    max : 10,
    delay : 100,
    minLength : 1,
    source : function(request,response) { $.ajax({
            url : '<?php echo $this->Html->url('/'); ?>produtos/ajaxBuscaPorNomeCodigoBarras',
        dataType : "json",
        data : request,
        success : function(
        data) {
        response($.map( data,function( item) {

        if (item == 0) {
        return {rotulo : 0};
        };

        if (item.Produto.pro_quantidade <= 0) {
        return {rotulo : -1, idProduto : item.Produto.id, nomeProduto : item.Produto.pro_nome};
        };

        return {

        rotulo : item.Produto.pro_nome  + " (id = "  + item.Produto.id + ")",
        value : item.pro_nome,
        idProduto : item.Produto.id,
        nomeProduto : item.Produto.pro_nome,
        precoPoduto : item.Produto.pro_preco,
        quantProduto : item.Produto.pro_quantidade

        }

        }));
        }

        });
        },
        minLength : 1,
        select : function( event,ui) {

        if (ui.item.rotulo != 0 && ui.item.rotulo != -1) {

        $("#AddMoreFileBox").click();

        $("#produto_"+ FieldCount).attr("value",ui.item.nomeProduto + " (id = "+ ui.item.idProduto+ ") Disponível - "+ui.item.quantProduto);

        $("#preco_"+ FieldCount).attr( "value", ui.item.precoPoduto);

        $("#idProduto_" + FieldCount) .attr("value",ui.item.idProduto);

        recalc();

        }

        }

        }).data("uiAutocomplete")._renderItem = function (ul, item) {

        if (item.rotulo == 0) {

        ul.addClass('customClass');

        return $("<li></li>")

        .append("<a target='_blank' href='<?php echo $this->Html-> url('/'); ?>produtos/novo'><?php echo __('Adicionar produto') ?></a>")

    .data("ui-autocomplete-item", "a")

    .appendTo(ul);

    };

    if (item.rotulo == -1) {

    ul.addClass('customClass');

    return $("<li></li>")

    .append("<a target='_blank' href='<?php echo $this-> Html-> url('/'); ?>produtos/editar/ "+item.idProduto+"'><?php echo __(' Quant. indisponível - Editar produto - "+item.nomeProduto+"') ?></a>")

    .data("ui-autocomplete-item", "a")

    .appendTo(ul);

    };

    ul.addClass('customClass');

    return $("<li></li>")

    .append("<a>" + item.rotulo + "</a>")

    .data("ui-autocomplete-item", item)

    .appendTo(ul);

    };

    });
</script> 
                <!-- cálculo automática da venda --> 
                <script type="text/javascript">
                    var bIsFirebugReady = (!!window.console && !!window.console.log);

                    $(document).ready(function() {
                        // update the plug-in version
                        $("#idPluginVersion").text($.Calculation.version);

                        /*
                        $.Calculation.setDefaults({
                        onParseError: function(){
                        this.css("backgroundColor", "#cc0000")
                        }
                        , onParseClear: function (){
                        this.css("backgroundColor", "");
                        }
                        });
                        */

                        // bind the recalc function to the quantity fields
                        $("[id^=quantidade_]").bind("keyup", recalc);
                        // run the calculation function now
                        recalc();

                        // automatically update the "#totalSum" field every time
                        // the values are changes via the keyup event
                        $("input[name^=sum]").sum("keyup", "#totalSum");

                        // automatically update the "#totalAvg" field every time
                        // the values are changes via the keyup event
                        $("input[name^=avg]").avg({
                            bind : "keyup",
                            selector : "#totalAvg"
                            // if an invalid character is found,  change the background color
                            ,
                            onParseError : function() {
                                this.css("backgroundColor", "#cc0000")
                            }
                            // if the error has been cleared,  reset the bgcolor
                            ,
                            onParseClear : function() {
                                this.css("backgroundColor", "");
                            }
                        });

                        // automatically update the "#minNumber" field every time
                        // the values are changes via the keyup event
                        $("input[name^=min]").min("keyup", "#numberMin");

                        // automatically update the "#minNumber" field every time
                        // the values are changes via the keyup event
                        $("input[name^=max]").max("keyup", {
                            selector : "#numberMax",
                            oncalc : function(value, options) {
                                // you can use this to format the value
                                $(options.selector).val(value);
                            }
                        });

                        // this calculates the sum for some text nodes
                        $("#idTotalTextSum").click(function() {
                            // get the sum of the elements
                            var sum = $(".textSum").sum();

                            // update the total
                            $("#totalTextSum").text("$" + sum.toString());
                        });

                        // this calculates the average for some text nodes
                        $("#idTotalTextAvg").click(function() {
                            // get the average of the elements
                            var avg = $(".textAvg").avg();

                            // update the total
                            $("#totalTextAvg").text(avg.toString());
                        });
                    });

                    //calcula automática só mudando a quantidade
                    function recalc() {
                        $("[id^=total_item]").calc(
                        // the equation to use for the calculation
                        "qty * price",
                        // define the variables used in the equation, these can be a jQuery object
                        {
                            qty : $("input[id^=quantidade_]"),
                            price : $("[id^=preco_]")
                        },
                        // define the formatting callback, the results of the calculation are passed to this function
                        function(s) {
                            // return the number as a dollar amount
                            return "R$" + s.toFixed(2);
                        },
                        // define the finish callback, this runs after the calculation has been complete
                        function($this) {
                            // sum the total of the $("[id^=total_item]") selector
                            var sum = $this.sum();

                            $("#grandTotal").text(
                            // round the results to 2 digits
                            "R$" + sum.toFixed(2));
                            //retorna o valor tbm para o input do formulário o total

                            $("#totalVenda").attr("value", sum.toFixed(2));

                        });
                    }
</script>

