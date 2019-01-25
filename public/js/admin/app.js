var init = {

    functions: {
        // CSRF token
        csrf: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },

        // Config Alertify
        alertify: function () {
            alertify.defaults = {
                // dialogs defaults
                autoReset: false,
                basic: false,
                closable: true,
                closableByDimmer: true,
                frameless: false,
                maintainFocus: true, // <== global default not per instance, applies to all dialogs
                maximizable: true,
                modal: true,
                movable: true,
                moveBounded: false,
                overflow: true,
                padding: true,
                pinnable: true,
                pinned: true,
                preventBodyShift: false, // <== global default not per instance, applies to all dialogs
                resizable: true,
                startMaximized: false,
                transition: 'pulse',
                onshow: function () {
                    $('.ajs-button').css('display', 'inline');
                },

                // notifier defaults
                notifier: {
                    // auto-dismiss wait time (in seconds)
                    delay: 5,
                    // default position
                    position: 'bottom-right',
                    // adds a close button to notifier messages
                    closeButton: false
                },

                // language resources
                glossary: {
                    // dialogs default title
                    title: '<h3>Confirma Ação?</h3>',
                    // ok button text
                    ok: 'Confirmar',
                    // cancel button text
                    cancel: 'Cancelar'
                },

                // theme settings
                theme: {
                    // class name attached to prompt dialog input textbox.
                    input: 'ajs-input',
                    // class name attached to ok button
                    ok: 'btn--success relative',
                    // class name attached to cancel button
                    cancel: 'btn--danger relative'
                }
            };
        },

        // Confirm Alertify
        confirm: function (message, response) {
            alertify.confirm(message,
                function () {
                    response(true);
                },
                function () {
                    response(false);
                }
                );
        },

        // Save sortable
        saveSort: function (url, callback) {
            var data = [];

            $('[data-id]').each(
                function (key, value) {
                    data.push($(value).attr('data-id'));
                });

            $.ajax({
                url: url,
                data: {
                    'ordem': data
                },
                method: 'post'
            }).done(
            function (data) {
                callback(data);
            });
        },

        changeStatus: function (id, status, url, callback) {
            $.ajax({
                url: url + 'alterar-status',
                data: {
                    'id': id
                },
                method: 'put'
            }).done(
            function (data) {
                callback(JSON.parse(data));
            });
        },
        adicionarTabelaDestaque(e){
            var max_itens = $("#destaques_form").data('max_itens');
            var id = $("[name=destaques_select] option:selected").data('dp_id');
            var nome = $("[name=destaques_select] option:selected").data('name');

            if(!id){
                return;
            }

            if($('[data-id='+id+']').length > 0){
                alertify.error('Item já está na lista');
                return false;
            }

            if(max_itens > 0 && typeof max_itens != 'undefined' ){
                if($('[data-id]').length >= max_itens){
                    alertify.error('Já existem '+max_itens+' itens la lista');
                    return false;
                }
            }

            var base_html = '<tr class="tr" data-id="'+id+'"><input type="hidden" name="destaques[]" value="'+id+'"><td class="td pd-10" data-th="Nome"><p class="col"> '+nome+'</p></td><td class="td pd-10" data-th="Ações"><div class="flex-grid col-0 valign-middle"><a href="#" prevent-default data-remove="'+id+'" data-text-'+id+'="Confirmar exclusão: '+nome+'" class="btn--danger btn-small btn-noborder btn-nomargin font-small col-0 mg-10--left relative"><i class="fa fa-trash-o"></i></a></div></td></tr>';
            $('#destaques_form table tbody').append(base_html);
            alertify.success('Item inserido');
            init.functions.setDnD();
        },
        // sendForm(e){
        //     e.preventDefault();
        //     $('#destaques_form').submit();
        // },
        // setDnD(){
        //     $("#destaques_form table tbody").sortable();
        // }

    },

    events: function () {
        // GENÉRICO - confirmação de exclusão
        $(document).on('click', '[data-destroy]',
            function () {
                var href = $(this).attr('href'),
                text = $(this).attr('data-text-' + $(this).attr('data-destroy'));

                init.functions.confirm(text,
                    function (response) {
                        if (response) {
                            window.location.href = href;
                        }
                    });
            });

        // GENÉRICO - Prevent Default
        // $(document).on('click', '[prevent-default]',
        //     function (e) {
        //         e.preventDefault();
        //     });

        // // GENÉRICO - Save sortable
        // $(document).on('click', '[sort-save]',
        //     function () {
        //         init.functions.saveSort($(this).attr('href'),
        //             function (output) {
        //                 if (output) {
        //                     alertify.success('Ordem alterada com sucesso.');
        //                 } else {
        //                     alertify.error('Não foi possível alterar a ordem, tente novamente.');
        //                 }
        //             });
        //     });

        $(document).on('change', '[data-change-status]',
            function () {
                var $this = $(this),
                status = $(this).val(),
                old = (status == '1') ? '0' : '1',
                id = $(this).attr('data-change-id'),
                url = $(this).attr('data-change-status');

                init.functions.confirm('Confirmar alteração do status?',
                    function (output) {
                        if (!output) {
                            $this.val(old);
                            return false;
                        }

                        init.functions.changeStatus(id, status, url,
                            function (output) {
                                (output) ?
                                alertify.success('Status alterado com sucesso.'): alertify.error('Não foi possível alterar o status.');
                            });
                    });
            });


        $(document).on('click', '[data-remove]',
            function () {
                var $this = $(this),
                id = $(this).attr('data-remove');

                init.functions.confirm('Confirmar remoção do item?',
                    function (output) {
                        if (!output) {
                            return false;
                        }

                        $('[data-id='+id+']').remove();
                        alertify.success('Removido com sucesso.');

                    });
            });

        $(document).on('change', '#add_destaque',
            function (e) {
                init.functions.adicionarTabelaDestaque(e);
            });

        $(document).on('click', '#submit_destaque',
            function (e) {
                init.functions.sendForm(e);
            });


        // $(document).ready(
        //     function (e) {
        //         init.functions.setDnD(e);
        //     });
    },

    plugins: {
        multipleSelect: function ($select) {
            $select.multipleSelect({
                placeholder: "Grupos",
                selectAllText: 'Selecionar tudo',
                allSelected: 'Tudo selecionado',
                countSelected: '# de % selecionados'
            });
        },

        datepicker: function () {
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                changeMonth: true,
                changeYear: true
            });
        },

        datetimepicker: function () {
            $.datetimepicker.setLocale('pt-BR');

            $('.datetimepicker').datetimepicker({
                format: 'd/m/Y H:i'
            });
        }
    }
};

init.functions.csrf();
init.functions.alertify();
init.plugins.datepicker();
init.plugins.datetimepicker();
init.events();
