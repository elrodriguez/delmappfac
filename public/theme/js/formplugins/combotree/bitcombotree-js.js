$.fn.bitcombotree = function () {
    $(this).css('display', 'none');

    var objetoSel = $(this);
    var idSel = $(this).attr('id');
    var changeSel = $(this).attr('data-change');
    var datadefault = $(this).attr('data-default');

    var dataSel = JSON.parse($(this).attr('data'));
    //console.log(dataSel)
    var vals = $('#' + idSel + ' option:selected').val();
    var texs = $('#' + idSel + ' option:selected').text();

    if (vals != '') {
        textdefault = texs;
        valdefault = vals;
    } else {
        textdefault = 'Seleccionar...';
        valdefault = '';
    }

    c = 0;

    var objetoDiv = '<div id="bitcombotree-'+idSel+'" class="bitcombotree" >';
    //inicio del head
    objetoDiv += '<div class="form-control bitcombotree-input" style="cursor:pointer;" onclick="$(\'#vidbody-' + idSel + '\').toggle(\'swing\');">';
    objetoDiv += '<span id="text-' + idSel + '" style="font-family: sans-serif;font-size: 100%;">' + textdefault + '</span>';
    objetoDiv += '<span id="icon-' + idSel + '" class="icon"><i class="fal fa-angle-down"></i></span>';
    objetoDiv += '</div>';
    //fin del head
    objetoDiv += '<div class="bitcombotree-body" id="vidbody-' + idSel + '" style="display:none;">';
    objetoDiv += '<div class="bitcombotree-body-padding">';
    objetoDiv += '<ul class="bitcombotree-list">';

    if (dataSel != null) {
        var ubg = '**'
        if(datadefault!= null){
            ubg = datadefault.split('*');
        }

        $.each(dataSel, function(i, item) {
            objetoDiv += '<li class="bitcombotree-item">';
            objetoDiv += '<input type="checkbox" id="ci' + idSel + i + '" '+(ubg[0]==item.id?'checked':'')+' />';
            objetoDiv += '<label for="ci' + idSel + i + '" class="tree_label" style="font-family: sans-serif;font-size:100%;font-style: normal;font-weight: bold;">' + item.name + '</label>';
            objetoDiv += '<ul class="bitcombotree-list">';
            $.each(item.items, function(t, item) {
                objetoDiv += '<li class="bitcombotree-item">';
                objetoDiv += '<input type="checkbox" id="t' + idSel + t + item.id + '" '+(ubg[1]==item.id?'checked':'')+' />';
                objetoDiv += '<label for="t' + idSel + t + item.id +'" class="tree_label" style="font-family: sans-serif;font-size:100%;font-style: normal;font-weight: bold;">' + item.name + '</label>';
                objetoDiv += '<ul>';
                $.each(item.items, function(k, item) {
                    if(ubg[2]==item.id){
                        valdefault = item.name;
                    }
                    objetoDiv += '<li><span onclick="$(\'#vidbody-' + idSel + '\').toggle(\'swing\');$(\'#' + idSel + '\').on(\'change\','+changeSel+'(\'' + item.all_id + '\'));$(\'#text-' + idSel + '\').text(\'' + item.name + '\');" class="aclick '+(ubg[2]==item.id?'tree_active':'tree_inactive')+'" >' + item.name + '</span></li>';
                });
                objetoDiv += '</ul></li>';
            });
            objetoDiv += '</ul></li>';
        });

    }else{

        $('#' + idSel + ' optgroup').each(function () {
            $(this).attr('id', 'bit-optgroup-' + c);
            objetoDiv += '<li class="bitcombotree-item">';
            objetoDiv += '<input type="checkbox" id="c' + c + '" />';
            objetoDiv += '<label for="c' + c + '" class="tree_label" style="font-family: sans-serif;font-size:100%;font-style: normal;font-weight: bold;">' + $(this).attr('label') + '</label>';
            objetoDiv += '<ul>';
            $('#bit-optgroup-' + c + ' option').each(function () {
                objetoDiv += '<li><span onclick="$(\'#vidbody-' + idSel + '\').toggle(\'swing\');$(\'#' + idSel + '\').val(\'' + $(this).val() + '\');$(\'#text-' + idSel + '\').text(\'' + $(this).text() + '\');" class="tree_label aclick" style="cursor:pointer;font-family: sans-serif;font-size: 100%;font-style: italic;">' + $(this).text() + '</span></li>';
            });
            objetoDiv += '</ul></li>';
            c++;
        });

    }
    $(this).attr('id', idSel + '-rename');
    $(this).attr('name', idSel + '-rename');

    objetoDiv += '</ul><input id="' + idSel + '" name="' + idSel + '" type="hidden" value="' + valdefault + '">';
    objetoDiv += '</div>';
    objetoDiv += '</div>';
    objetoDiv += '</div>';
    objetoSel.after($.parseHTML(objetoDiv));
    if(datadefault != null){
        $('#text-ubigeo').text(valdefault);
    }

};
