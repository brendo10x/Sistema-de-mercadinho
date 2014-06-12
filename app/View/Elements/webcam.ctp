    <?php
    //script 
     echo $this -> Html -> script('jquery.webcam');
    ?>
    

                                             <script type="text/javascript">
                                                jQuery("#webcamBotoes").hide();
                                                var pos = 0;
                                                var ctx = null;
                                                var cam = null;
                                                var image = null;
                                                var filter_on = false;
                                                var filter_id = 0;
                                                function changeFilter() {
                                                    if (filter_on) {
                                                        filter_id = (filter_id + 1) & 7;
                                                    }
                                                }

                                                function toggleFilter(obj) {
                                                    if (filter_on != filter_on) {
                                                        obj.parentNode.style.borderColor = "#c00";
                                                    } else {
                                                        obj.parentNode.style.borderColor = "#333";
                                                    }
                                                }

                                                jQuery("#webcam").webcam({
                                                    width: 320, //320
                                                    height: 240, //240
                                                    mode: "callback",
                                                    swffile: "<?php echo $this->Html->url('/files/jscam.swf '); ?> ",
                                                    onTick: function(remain) {

                                                        if (0 == remain) {
                                                            string = "<?php echo __('Escolha') ?>!";
                                                        } else {
                                                            string = remain + " <?php echo __('segundos restantes') ?>...";
                                                        }
                                                        webcam.debug("notify", string);
                                                    },
                                                    onSave: function(data) {

                                                        var col = data.split(";");
                                                        var img = image;
                                                        if (false == filter_on) {

                                                            for (var i = 0; i < 320; i++) {
                                                                var tmp = parseInt(col[i]);
                                                                img.data[pos + 0] = (tmp >> 16) & 0xff;
                                                                img.data[pos + 1] = (tmp >> 8) & 0xff;
                                                                img.data[pos + 2] = tmp & 0xff;
                                                                img.data[pos + 3] = 0xff;
                                                                pos += 4;
                                                            }

                                                        } else {

                                                            var id = filter_id;
                                                            var r, g, b;
                                                            var r1 = Math.floor(Math.random() * 255);
                                                            var r2 = Math.floor(Math.random() * 255);
                                                            var r3 = Math.floor(Math.random() * 255);
                                                            for (var i = 0; i < 320; i++) {
                                                                var tmp = parseInt(col[i]);
                                                                /* Copied some xcolor methods here to be faster than calling all methods inside of xcolor and to not serve complete library with every req */

                                                                if (id == 0) {
                                                                    r = (tmp >> 16) & 0xff;
                                                                    g = 0xff;
                                                                    b = 0xff;
                                                                } else if (id == 1) {
                                                                    r = 0xff;
                                                                    g = (tmp >> 8) & 0xff;
                                                                    b = 0xff;
                                                                } else if (id == 2) {
                                                                    r = 0xff;
                                                                    g = 0xff;
                                                                    b = tmp & 0xff;
                                                                } else if (id == 3) {
                                                                    r = 0xff ^ ((tmp >> 16) & 0xff);
                                                                    g = 0xff ^ ((tmp >> 8) & 0xff);
                                                                    b = 0xff ^ (tmp & 0xff);
                                                                } else if (id == 4) {

                                                                    r = (tmp >> 16) & 0xff;
                                                                    g = (tmp >> 8) & 0xff;
                                                                    b = tmp & 0xff;
                                                                    var v = Math.min(Math.floor(.35 + 13 * (r + g + b) / 60), 255);
                                                                    r = v;
                                                                    g = v;
                                                                    b = v;
                                                                } else if (id == 5) {
                                                                    r = (tmp >> 16) & 0xff;
                                                                    g = (tmp >> 8) & 0xff;
                                                                    b = tmp & 0xff;
                                                                    if ((r += 32) < 0)
                                                                        r = 0;
                                                                    if ((g += 32) < 0)
                                                                        g = 0;
                                                                    if ((b += 32) < 0)
                                                                        b = 0;
                                                                } else if (id == 6) {
                                                                    r = (tmp >> 16) & 0xff;
                                                                    g = (tmp >> 8) & 0xff;
                                                                    b = tmp & 0xff;
                                                                    if ((r -= 32) < 0)
                                                                        r = 0;
                                                                    if ((g -= 32) < 0)
                                                                        g = 0;
                                                                    if ((b -= 32) < 0)
                                                                        b = 0;
                                                                } else if (id == 7) {
                                                                    r = (tmp >> 16) & 0xff;
                                                                    g = (tmp >> 8) & 0xff;
                                                                    b = tmp & 0xff;
                                                                    r = Math.floor(r / 255 * r1);
                                                                    g = Math.floor(g / 255 * r2);
                                                                    b = Math.floor(b / 255 * r3);
                                                                }

                                                                img.data[pos + 0] = r;
                                                                img.data[pos + 1] = g;
                                                                img.data[pos + 2] = b;
                                                                img.data[pos + 3] = 0xff;
                                                                pos += 4;
                                                            }
                                                        }

                                                        if (pos >= 0x4B000) {
                                                            ctx.putImageData(img, 0, 0);
                                                            pos = 0;
                                                        }
                                                    },
                                                    onCapture: function() {
                                                        webcam.save();
                                                        jQuery("#flash").css("display", "block");
                                                        jQuery("#flash").fadeOut(100, function() {
                                                            jQuery("#flash").css("opacity", 1);
                                                        });
                                                    },
                                                    debug: function(type, string) {
                                                        if (type == "notify") {

                                                            type = "<?php echo __('Notificação') ?> ";
                                                            jQuery("#labelCamDisponivel").show();
                                                            jQuery("#webcam").show();
                                                            $("#carregandoInfoWebcam").hide();
                                                        }
                                                        if (type == "error") {

                                                            type = "<?php echo __('Erro') ?>  ";
                                                            jQuery("#webcamBotoes").hide();
                                                            jQuery("#labelCamDisponivel").hide();
                                                            jQuery("#webcam").hide();
                                                            jQuery("#cams").hide();
                                                        }

                                                        if (string == "Camera started") {
                                                            jQuery("#webcamBotoes").show();
                                                            string = "<?php echo __('Câmera está em funcionamento'); ?> ";
                                                        }
                                                        if (string == "Camera stopped") {
                                                            string = "<?php echo __('Câmera foi interrompida, atualize a página e aperte no botão permitir'); ?>  ";
                                                            jQuery("#webcamBotoes").hide();
                                                            jQuery("#labelCamDisponivel").hide();
                                                            jQuery("#webcam").hide();
                                                            jQuery("#cams").hide();
                                                        }
                                                        if (string == "Capturing finished.") {
                                                            string = "<?php echo __('Foto capturada'); ?>   ";
                                                            $("#ocultaConteudoCanvas").show();
                                                            $("#confirmaCanvas").text("<?php echo __('Confirmar foto') ?>!");
                                                            $("#msgFotoNaoconfirmadaCanvas").show();
                                                            $("#msgFotoconfirmadaCanvas").hide();
                                                        }
                                                        if (string == "No camera was detected.") {
                                                            string = "<?php echo __('Nenhuma câmera foi detectada'); ?> ";
                                                        }
                                                        if (string == "Flash movie not yet registered!") {
                                                            string = "<?php echo __('Atualize a página ou ative a câmera do hardware e atualize novamente'); ?>   ";
                                                            $("#carregandoInfoWebcam").hide();
                                                        }

                                                        jQuery("#status").html(type + ": " + string);
                                                    },
                                                    onLoad: function() {

                                                        webcam.debug("notify", "<?php echo __('Aperte no botão permitir no FLASH acima'); ?> ");
                                                        var cams = webcam.getCameraList();
                                                        for (var i in cams) {
                                                            jQuery("#cams").append("<li>" + cams[i] + "</li>");
                                                        }

                                                    }
                                                });
                                                window.addEventListener("load", function() {

                                                    var canvas = document.getElementById("canvas");
                                                    if (canvas.getContext) {
                                                        ctx = document.getElementById("canvas").getContext("2d");
                                                        ctx.clearRect(0, 0, 320, 240);
                                                        var img = new Image();
                                                        img.src = "<?php echo $this->Html->url('/img/sem-foto.png '); ?> ";
                                                        img.onload = function() {
                                                            ctx.drawImage(img, 0, 0, 320, 240);
                                                        }
                                                        image = ctx.getImageData(0, 0, 320, 240);
                                                    }

                                                }, false);</script>

                                            

                                            <!--Script em conjunto com webcam--> 
                                            <script>
                                                $("#ocultaConteudoCanvas").hide();
                                                $("#msgFotoconfirmadaCanvas").hide();
                                                $("#confirmaCanvas").click(function() {
                                                    // Pega os dados da Imagem gerada no canvas
                                                    var desenho = document.getElementById("canvas").toDataURL("image/png");
                                                    desenho = desenho.replace('data:image/png;base64,', '');
                                                    $('#fotoCanvas').attr("value", desenho);
                                                    $("#confirmaCanvas").text("<?php echo __('Foto confirmada') ?>!");
                                                    $("#msgFotoNaoconfirmadaCanvas").hide();
                                                    $("#msgFotoconfirmadaCanvas").show();
                                                });
                                                $("#capturaCanvas2").click(function() {

                                                    $("#ocultaConteudoCanvas").show();
                                                    $("#confirmaCanvas").text("<?php echo __('Confirmar foto') ?>!");
                                                    $("#msgFotoNaoconfirmadaCanvas").show();
                                                    $("#msgFotoconfirmadaCanvas").hide();
                                                });
                                                $("#naoConfirmaCanvas").click(function() {

                                                    $("#ocultaConteudoCanvas").hide();
                                                    $('#fotoCanvas').attr("value", "");
                                                });</script> 
                                                