$("#btnUserUpdate").on("click",function(e){e.preventDefault();var t=$("#formUserUpdate"),a=t.attr("action"),o=t.serialize(),s=$(".form-content.info-personal");$.ajax({url:a,type:"POST",data:o,beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},success:function(e){var t='<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';s.html(t)},error:function(e){if(422===e.status){var t=e.responseJSON,a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';$.each(t,function(e,t){a+="<li>"+t[0]+"</li>"}),a+="</ul></div>",s.html(a)}else a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>',a+="<li>Se ha producido un error. Intentelo de nuevo.</li>",a+="</ul></div>",s.html(a)}})}),$("#btnTarifaUpdate").on("click",function(e){e.preventDefault();var t=$("#formTarifaUpdate"),a=t.attr("action"),o=t.serialize(),s=$(".form-content.tarifas");$.ajax({url:a,type:"POST",data:o,beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},success:function(e){var t='<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';s.html(t)},error:function(e){if(422===e.status){var t=e.responseJSON,a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';$.each(t,function(e,t){a+="<li>"+t[0]+"</li>"}),a+="</ul></div>",s.html(a)}else a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>',a+="<li>Se ha producido un error. Intentelo de nuevo.</li>",a+="</ul></div>",s.html(a)}})});var myDropzone=new Dropzone(".dropzone",{dictDefaultMessage:"Da clic para seleccionar el archivo",dictMaxFilesExceeded:"No se puede cargar más archivos",method:"POST",headers:{"X-CSRF-Token":"{!! csrf_token() !!}"},maxFiles:1,autoProcessQueue:!1,success:function(e,t){var a="/imagenes/"+t.carpeta+"250x250/"+t.archivo;$("#fotoUsuario").attr("src",a),myDropzone.removeAllFiles()}});$("#btnFotoCambiar").on("click",function(){myDropzone.processQueue()}),$("#btnFotoEliminar").on("click",function(){myDropzone.removeAllFiles()}),$("#btnFotoEliminarActual").on("click",function(e){e.preventDefault();var t=$(this).data("url"),a=$(".form-content.cambiar-foto");$.ajax({url:t,type:"POST",headers:{"X-CSRF-Token":"{!! csrf_token() !!}"},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},success:function(e){var t="/imagenes/user.png";$("#fotoUsuario").attr("src",t);var o='<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';a.html(o)},error:function(e){if(422===e.status){var t=e.responseJSON,o='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';$.each(t,function(e,t){o+="<li>"+t[0]+"</li>"}),o+="</ul></div>",a.html(o)}else o='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>',o+="<li>Se ha producido un error. Intentelo de nuevo.</li>",o+="</ul></div>",a.html(o)}})}),$("#btnPasswordUpdate").on("click",function(e){e.preventDefault();var t=$("#formPasswordUpdate"),a=t.attr("action"),o=t.serialize(),s=$(".form-content.cambiar-clave");$.ajax({url:a,type:"POST",data:o,beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},success:function(e){var a;a=1==e.correo?"La contraseña se envío por correo al usuario.":"";var o='<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente. '+a+"</div>";s.html(o),t[0].reset(),$(".checker span").removeClass("checked")},error:function(e){if(422===e.status){var t=e.responseJSON,a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';$.each(t,function(e,t){a+="<li>"+t[0]+"</li>"}),a+="</ul></div>",s.html(a)}else a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>',a+="<li>Se ha producido un error. Intentelo de nuevo.</li>",a+="</ul></div>",s.html(a)}})}),$("#btnPermisosUpdate").on("click",function(e){e.preventDefault();var t=$("#formPermisosUpdate"),a=t.attr("action"),o=t.serialize(),s=$(".form-content.cambiar-permisos");$.ajax({url:a,type:"POST",data:o,beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},success:function(e){var t='<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';s.html(t)},error:function(e){if(422===e.status){var t=e.responseJSON,a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';$.each(t,function(e,t){a+="<li>"+t[0]+"</li>"}),a+="</ul></div>",s.html(a)}else a='<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>',a+="<li>Se ha producido un error. Intentelo de nuevo.</li>",a+="</ul></div>",s.html(a)}})});