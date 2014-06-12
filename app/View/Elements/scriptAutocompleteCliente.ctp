    <script type="text/javascript">
                            $(document)
        .ready(
            function() {
                $("#cliente")
                .autocomplete( {
                    width : 300,
                    max : 10,
                    delay : 100,
                    minLength : 1,
                    source : function(
                        request,
                        response) {
                        $.ajax({ url : '<?php echo $this -> Html -> url('/'); ?>clientes/ajaxBuscaPorNome',
                            dataType : "json",
                            data : request,
                            success : function(data) {

                            response($.map(data, function(item) {

                            if (item == 0) {
                            return {label : ''};
                            };

                            return {

                            label : item.Pessoas.pes_nome,
                            variavel : item.Cliente.id,
                            icon: item.Pessoas.pes_foto
                            }

                            }));
                            }

                            });
                            },
                            minLength : 1,
                            select : function( event, ui) {

                            $( "#idCliente") .attr( "value", ui.item.variavel);

                            }

                            }).data("uiAutocomplete")._renderItem = function (ul, item) {

                            if (item.label == '') {

                            ul.addClass('customClass');

                            return $("<li></li>")

                            .append("<a target='_blank' href='<?php echo $this->Html->url('/'); ?>clientes/novo'><?php echo __('Adicionar cliente') ?></a>")

                            .data("ui-autocomplete-item", "a")
                        
                            .appendTo(ul);
                        
                            };
                        
                            ul.addClass('customClass');
                        
                            return $("<li></li>")
                        
                            .append("<a >" + item.label + "</a>")
                        
                            .data("ui-autocomplete-item", item)
                        
                            .appendTo(ul);
                            };
                            });
                </script>