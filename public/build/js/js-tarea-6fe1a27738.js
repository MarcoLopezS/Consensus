function borrarAccion(){$(".btn-delete").on("click",function(a){a.preventDefault();var t=$(this).data("url"),e=$(this).data("title"),s=$(this).data("accion");bootbox.dialog({title:"Eliminar registro",message:"<strong>Desea eliminar la acción:</strong> "+e,closeButton:!1,buttons:{cancel:{label:"Cancelar",className:"default"},success:{label:"Eliminar",className:"blue",callback:function(){$.ajax({url:t,type:"POST",data:{_method:"DELETE"},headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},success:function(a){$("#mensajeAjax").show(),$("#mensajeAjax .alert").show().removeClass("alert-danger").addClass("alert-success"),$("#mensajeAjax span").text(a.message),$("#accion-select-"+s).fadeOut()},error:function(a){$("#mensajeAjax").show(),$("#mensajeAjax .alert").show().removeClass("alert-success").addClass("alert-danger"),$("#mensajeAjax span").text("Se produjo un error al eliminar el registro"),$(".accion-select-"+s).show()}})}}}})})}$(".tarea-acciones").on("click",function(a){a.preventDefault();var t=$(this).data("id"),e=$(this).data("list"),s=$(this).data("create");$.ajax({url:e,type:"GET",success:function(a){var e='<tr id="accion-'+t+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23"><div class="btn-group pull-left"><h3 class="table-title">Acciones</h3></div><div class="btn-group pull-right table-botones"><a class="btn sbold white accion-cerrar" href="#" data-id="'+t+'"> Cerrar </a><a class="btn sbold blue-soft" href="'+s+'" data-target="#ajax" data-toggle="modal"> Agregar nueva acción <i class="fa fa-plus"></i></a></div><table id="accion-lista-'+t+'" class="table table-striped table-bordered table-hover order-column"><thead><tr role="row" class="heading"><td>Fecha</td><td>Desde</td><td>Hasta</td><td>Horas</td><td>Descripcion</td><td></td></tr></thead><tbody></tbody></table></td></tr>';$("#tarea-"+t).after(e),$.each(JSON.parse(a),function(a,e){n=$('<tr id="accion-select-'+e.id+'">'),n.append("<td>"+e.fecha_accion+"</td>"),n.append("<td>"+e.desde+"</td>"),n.append("<td>"+e.hasta+"</td>"),n.append("<td>"+e.horas+"</td>"),n.append("<td>"+e.descripcion+"</td>"),n.append('<td class="text-center"><div class="btn-group"><button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos<i class="fa fa-angle-down"></i></button><ul class="dropdown-menu pull-right" role="menu"><li><a href="'+e.url_lista_gastos+'" data-target="#ajax" data-toggle="modal">Gastos</a></li><li><a href="'+e.url_editar+'" data-target="#ajax" data-toggle="modal">Editar</a></li><li><a href="#" data-url="'+e.url_eliminar+'" data-title="'+e.descripcion+'" data-accion="'+e.id+'" class="btn-delete">Eliminar</a></li></ul></div></td></tr>'),$("#accion-lista-"+t+" tbody").append(n)}),$("#accion-"+t).fadeIn(),borrarAccion();var n;$(".accion-cerrar").on("click",function(a){a.preventDefault();var t=$(this).data("id");$("#accion-"+t).fadeOut()})},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},error:function(){}})});