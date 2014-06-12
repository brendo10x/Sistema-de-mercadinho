

<div id="main-content" > 
    <!--início #main-content-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title"><?php echo $titulo ?></h3>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo $this -> Html -> url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
                    <li><a href="<?php echo $this -> Html -> url(array("controller" => "relatorios", "action" => "relatorios_vendas")); ?>"><?php echo $breadcrumb ?></a><span class="divider">&nbsp;</span></li>
                    <li> <a href="#"><?php echo $titulo ?></a><span class="divider-last">&nbsp;</span> </li>
                </ul>
            </div>
        </div>
      
 
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i><?php echo __('Tabela de dados') ?></h4>
                        <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
                        <div class="widget-body">
                            <div class="dataTables_wrapper form-inline" role="grid">

                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="tabbable tabbable-custom tabs-left">
                                            <ul class="nav nav-tabs tabs-left">
                                                <li <?php (!empty($tab_1)) ? print ' class="active" ' : null; ?> > 
                                                    <a href="#tab_3_1" data-toggle="tab"><?php  echo __('Vendas no mês ou dia') ?></a>
                                                </li>
                                                 <li <?php (!empty($tab_2)) ? print ' class="active" ' : null; ?> > 
                                                    <a href="#tab_3_2" data-toggle="tab"><?php  echo __('Vendas no mês ou dia vendedor') ?></a>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane <?php (!empty($tab_1)) ? print ' active ' : null; ?> " id="tab_3_1">

                                                  <form id="formDados"  action="<?php echo $this -> Html -> url(array("controller" => "relatorios", "action" => "relatorios_vendas", "buscar")); ?>" method="post">

                                                        <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">
                                                        <input autocomplete="off" placeholder="<?php echo __('Data') ?>..." required="true" class="span2 datepicker" name="data[buscar]" value="<?php (!empty($data)) ? print $data : null; ?>"  type="text"  />
                                                          
                                                </form>

                                            </div>

                                            <div class="tab-pane <?php (!empty($tab_2)) ? print ' active ' : null; ?>"  id="tab_3_2">

                                             <form id="formDados2" action="<?php echo $this -> Html -> url(array("controller" => "relatorios", "action" => "relatorios_vendas", "buscar")); ?>" method="post">
                                                 
                                                 <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">
                                                  <input autocomplete="off" required="true" placeholder="<?php echo __('Data') ?>..." class="span2 datepicker" name="data[buscar2]" data-date-format="dd-mm-yyyy" value="<?php (!empty($data2)) ? print $data2 : null; ?>"  type="text" value="02/2012" />
                                                   
                                                <input autocomplete="off" required="true" type="text" id="vendedor"   placeholder="<?php echo __('Vendedor') ?>..." class="span4" value="<?php (!empty($nomeVendedor)) ? print $nomeVendedor : null; ?>">
                                                 <input type="hidden" id="idVendedor"  value="<?php (!empty($idVendedor)) ? print $idVendedor : null; ?>"   name="data[Vendedor][id]"  />
                                               

                                            </form> 
                                        </div>
                                    </div>
                                </div>


                            </div><!-- span principal -->
                        </div>


                      <script type="text/javascript">
                                                                                                                                                                                                                                                                                $(document)
        .ready(
            function() {
                $("#vendedor")
                .autocomplete( {
                    width : 300,
                    max : 10,
                    delay : 100,
                    minLength : 1,
                    source : function(
                        request,
                        response) {
                        $.ajax({ url : '<?php echo $this -> Html -> url('/'); ?>vendedores/ajaxBuscaPorNome',
                            dataType : "json",
                            data : request,
                            success : function(data) {

                            response($.map(data, function(item) {

                            if (item == 0) {
                            return {label : ''};
                            };

                            return {

                            label : item.Pessoas.pes_nome,
                            variavel : item.Vendedor.id,

                            }

                            }));
                            }

                            });
                            },
                            minLength : 1,
                            select : function( event, ui) {

                            $( "#idVendedor") .attr( "value", ui.item.variavel);

                            }

                            }).data("uiAutocomplete")._renderItem = function (ul, item) {

                            if (item.label == '') {

                            ul.addClass('customClass');

                            return $("<li></li>")

                            .append("<a target='_blank' href='<?php echo $this -> Html -> url('/'); ?>vendedores/novo'><?php echo __('Adicionar vendedor') ?> </a>")

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


                            <form id="excluir_selecionados"  action="<?php echo $this -> Html -> url(array("controller" => "vendas", "action" => "excluir_selecionados")); ?>" method="post">
                                <table class="table table-striped table-bordered dataTable" >
                                    <span style="display:none" id="carregandoInfo" ><img src="<?php echo $this -> Html -> url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>
                                    <thead>
                                        <tr role="row">

                                            <th style="width: 10%;"><?php echo __('Registro') ?></th>

                                            <?php $label = __('Total'); ?>

                                            <th class="sorting" role="columnheader" style="width: 25%;"> <?php if ($totalRegistros >= 1) { ?>

                                                <?php echo $this -> Paginator -> sort('Venda.ven_total', $label); ?>
                                                <?php
                                                } else {

                                                echo $label;
                                              ?>

                                              <?php } ?>

                                          </th>
                                          
                                            <?php $label = __('Vendedor'); ?>

                                            <th class="hidden-phone sorting" role="columnheader" style="width: 45%;">  <?php if ($totalRegistros >= 1) { ?>

                                                <?php echo $this -> Paginator -> sort('Pessoa.pes_nome', $label); ?>
                                                <?php
                                                } else {

                                                echo $label;
                                              ?>

                                              <?php } ?>

                                          </th>

                                          
                                          
                                      <?php $label = __('Data'); ?>
                                      <th class="hidden-phone sorting" style="width: 20%;"> <?php if ($totalRegistros >= 1) { ?>

                                        <?php echo $this -> Paginator -> sort('Venda.data', $label); ?>
                                        <?php
                                        } else {
                                        echo $label;
                                      ?>

                                      <?php } ?>
                                  </th>
                              </tr>
                          </thead>
                          <tbody  role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach ($vendas as $key => $value) { ?>
                            <tr class="gradeX odd">


                                <td><a class="botaoVisualizar btn btn-small btn-primary" id="id-visualizar-<?php echo $value['Venda']['id'] ?>" href="#modal<?php echo $value['Venda']['id'] ?>" role="button"  data-toggle="modal"> <i class="icon-eye-open"></i><?php echo __('Visualizar') ?></a>
                                </td>
                                <td><?php echo $value['Venda']['ven_total'] ?></td>
                                <td class="hidden-phone"><?php echo $value['Pessoas']['pes_nome'] ?></td>
                                <td class="hidden-phone"><?php echo $value['Venda']['data']  ?></td>
                            </tr>

                            <!--Informações modal-->
                            <div id="modal<?php echo $value['Venda']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $value['Venda']['id'] ?>" aria-hidden="true"> </div>

                            <?php } ?>
                            <?php if ($totalRegistros <= 0) { ?>
                            <tr  class="gradeX odd">
                                <td  colspan="5"><div style="text-align:center">
                                    <?php echo __('Nenhum registro encontrado') ?>!</td>
                                </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </form>



                    <?php if ($totalRegistros >= 1) { ?>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="dataTables_info"><?php echo $this -> Paginator -> counter(array('format' => __('Página %page% de %pages%, mostrando %current% registros de um total de %count%, indo do registro %start% até o %end%'))); ?></div>
                        </div>
                        <div class="span6">
                            <div class="dataTables_paginate paging_bootstrap pagination">
                                <ul>
                                            
                                        <!--Paginação-->
                                       <?php echo $this -> element('paginacao',array('tipo' => '')); ?>
                                    
                                </ul>
                            </div>
                            <?php } ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!--Visualizar -->
<?php echo $this->element('scriptVisualizar', array("controle" => "vendas")); ?>

<?php echo $this -> Html -> script('jquery.validate'); ?>
<?php echo $this -> Html -> script('jquery.validate.msg-'.$usuario['Config']['idioma']); ?>

<script type="text/javascript">
    //formulário
    $("#formDados").validate({

        //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>
    });

</script>

<script type="text/javascript">
    //formulário
    $("#formDados2").validate({

         //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>
    });

</script>
