var loader = function() {
    return {
        init: function () {
            $('body').addClass('page-loading');
            $('.page-loader').css('background', 'rgba(255,255,255,0.2').show();
        },
        destroy: function() {
            $('body').removeClass('page-loading');
            $('.page-loader').css('background', 'rgba(255,255,255,1').hide();
        }
    }
}();

var loader_dt = function() {
    return {
        init: function () {
            KTApp.block('.datatable', {
                overlayColor: '#FFFFFF',
                state: 'primary',
                message: 'Processing...'
            });
        },
        destroy: function() {
            KTApp.unblock('.datatable');
        }
    }
}();

var loader_tb = function() {
    return {
        init: function () {
            KTApp.block('#report-table', {
                overlayColor: '#FFFFFF',
                state: 'primary',
                message: 'Processing...'
            });
        },
        destroy: function() {
            KTApp.unblock('#report-table');
        }
    }
}();

String.prototype.ucwords = function() {
    return this.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
}

var formatter = new Intl.NumberFormat('en-EN', {
    maximumSignificantDigits: 20
});

$(function(){
    $(".selectpicker").selectpicker();

    $('body').delegate('.btn-action-delete','click',function(e){
        e.preventDefault();
        var $this=$(this);
        confirmModal.find('.modal-title > span').text('Warning : Delete Data');
        confirmModal.find('.modal-body').text('This action will delete this data permanently!');
        confirmModal.modal('show');

        confirmModal.find('.btn-modal-action').click(function(){
            document.location.href = $this.attr('href');
        });
    });

    $('.btn-loading').map(function(){
        var $this=$(this);
        $this.attr('data-initial-text', $this.html());
        $this.attr('data-loading-text', "<i class='fas fa-spinner spinner mr-8'></i> Loading...");
    });

    confirmModal.on('hidden.bs.modal', function (e) {
        var btn = confirmModal.find('.btn-modal-action'),
        initialText = btn.attr("data-initial-text");

        confirmModal.find(".modal-title > span").text("Warning");
        confirmModal.find(".modal-body").text("");
        confirmModal.find(".modal-footer > .btn-modal-action").removeAttr("data-action").removeAttr("data-params");

        btn.html(initialText).removeClass('disabled').prop("disabled",false);
    });

    alertModal.on('hidden.bs.modal', function (e) {
        var btn = alertModal.find('.btn-modal-action'),
        initialText = btn.attr("data-initial-text");

        alertModal.find(".modal-title > span").text("Alert");
        alertModal.find(".modal-body").text("");

        btn.html(initialText).removeClass('disabled').prop("disabled",false);
    });

    $('.required').each(function(){
        $('<span/>',{
            class: 'required-text text-danger',
            text: '*'
        }).appendTo($(this));
    });

    $('body').delegate('.checkbox > input:checkbox','click',function(e){
        var $this=$(this),$checkbox=$this.parents('.checkbox'),$color=$this.attr('data-color'),$parent=$this.attr('data-parent'),$alias=$this.attr('data-alias'),$roles=$this.parents('#role-'+$alias);

        $this.parents('.option').removeClass('bg-'+$color+'-o-30');
        if($this.is(':checked')){
            $this.parents('.option').addClass('bg-'+$color+'-o-30');
            if($('#view-'+$parent).find('input:checkbox').is(':checked')==false){
                $('#view-'+$parent).find('input:checkbox').trigger('click');
            }
            if($this.attr('data-role')!='view'){
                if($('#view-'+$alias).find('input:checkbox').is(':checked')==false){
                    $('#view-'+$alias).find('input:checkbox').prop('checked',true);
                    $('#view-'+$alias).parents('.option').addClass('bg-'+$('#view-'+$alias).find('input').attr('data-color')+'-o-30');
                }
            }
        }
        else{
            if($this.attr('data-role')=='view'){
                $roles.find('.checkbox > input[data-role!=view]').map(function(){
                    if($(this).is(':checked')==true){
                        $(this).prop('checked',false);
                        $(this).parents('.option').removeClass('bg-'+$(this).attr('data-color')+'-o-30');
                    }
                });

                $('.checkbox > input[data-parent='+$alias+']').map(function(){
                    if($(this).is(':checked')==true){
                        $(this).trigger('click');
                    }
                });
            }
        }
    });

    function formatOperator(r) {
        if (r.loading) return r.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + r.code + ' - ' +r.name + "</div></div>";
        return markup;
    }
    function formatOperatorSelection(r) {
        return r.code ? r.code + ' - ' +r.name : r.text;
    }

    $("#dt_select_operator").select2({
        placeholder: "Search by Operator",
        allowClear: true,
        ajax: {
            url: $("base").attr("href") + "/operator-list",
            method: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page,
                    _token: $("meta[name=csrf-token]").attr("content")
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: formatOperator,
        templateSelection: formatOperatorSelection
    });

    function formatGames(r) {
        if (r.loading) return r.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + r.name + "</div>" +
            "<div class='select2-result-repository__title'><p class='text-muted'>" +r.provider + "</p></div>" +
            "</div>";
        return markup;
    }
    function formatGamesSelection(r) {
        return r.name ? r.name + ' - ' +r.provider : r.text;
    }

    $("#dt_select_games").select2({
        placeholder: "Search by Game",
        allowClear: true,
        ajax: {
            url: $("base").attr("href") + "/games-list",
            method: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page,
                    _token: $("meta[name=csrf-token]").attr("content")
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: formatGames,
        templateSelection: formatGamesSelection
    });

    $('.select2-search').select2({

    });

    var drp = $(".date-range-period .input-group-append")
    drp.daterangepicker({
        buttonClasses:"m-btn btn",applyClass:"btn-primary",cancelClass:"btn-secondary",
        locale:{format:"DD MMM"},
        minDate: moment().subtract(31, 'days'),
        maxDate: new Date(moment().format("YYYY-MM-DD")),
    },function(a,b,n){
        $(".date-range-period #start").val(a.format("DD MMM Y")).attr('data-selected', a.format('Y-MM-DD'));
        $(".date-range-period #end").val(b.format("DD MMM Y")).attr('data-selected', b.format('Y-MM-DD'));
    });
    $('.select2-no-searchbox').select2({
        minimumResultsForSearch: Infinity
    });
});

var KTBootstrapDaterangepicker = function () {

    var dt = function () {

        if($('.datatable').is('div')){
            var drps = $(".date-range-picker-strict .input-group-append")
            drps.daterangepicker({
                buttonClasses:"m-btn btn",applyClass:"btn-primary",cancelClass:"btn-secondary",timePicker:!0,timePickerIncrement:1,
                locale:{format:"DD MMM Y h:mm A"},
                minDate: moment().subtract(13, 'days'),
                maxDate: new Date(moment().format("YYYY-MM-DD 23:59:59")),
            },function(a,b,n){
                if(a.format('Y-MM-DD') != b.format('Y-MM-DD')){
                    $(".date-range-picker-strict #start").val(a.format("DD MMM Y h:mm A")).attr('data-selected', a.format('Y-MM-DD HH:mm:ss'));
                    $(".date-range-picker-strict #end").val(a.format('DD MMM Y')+' '+b.format('h:mm A')).attr('data-selected', a.format('Y-MM-DD')+' '+b.format('HH:mm:59'));

                    drps.data('daterangepicker').setStartDate(a.format('DD MMM Y h:mm A'));
                    drps.data('daterangepicker').setEndDate(a.format('DD MMM Y')+' '+b.format('h:mm A'));
                }
                else{
                    $(".date-range-picker-strict #start").val(a.format("DD MMM Y h:mm A")).attr('data-selected', a.format('Y-MM-DD HH:mm:ss'));
                    $(".date-range-picker-strict #end").val(b.format("DD MMM Y h:mm A")).attr('data-selected', b.format('Y-MM-DD HH:mm:59'));
                }
            });
        }else{
            $('#datepicker').daterangepicker({
                buttonClasses: 'btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary'
            }, function(start, end, label) {
                $('#datepicker .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
            });

            $('#dateperiod').datepicker({
                format: "MM yyyy",
                startView: 1,
                minViewMode: 1,
                maxViewMode: 2,
                startDate: new Date(moment().subtract(6, 'months').format("YYYY-MM-DD")),
                endDate: new Date(moment().format("YYYY-MM-DD")),
            }).on('changeDate', function(e) {
                $("#dateperiod").attr('data-selected', moment(e.date).format("YYYY-MM-DD"));
            });

            var drp = $(".date-range-period .input-group-append")
            drp.daterangepicker({
                buttonClasses:"m-btn btn",applyClass:"btn-primary",cancelClass:"btn-secondary",
                locale:{format:"DD MMM"},
                minDate: moment().subtract(31, 'days'),
                maxDate: new Date(moment().format("YYYY-MM-DD")),
            },function(a,b,n){
                $(".date-range-period #start").val(a.format("DD MMM Y")).attr('data-selected', a.format('Y-MM-DD'));
                $(".date-range-period #end").val(b.format("DD MMM Y")).attr('data-selected', b.format('Y-MM-DD'));
            });

            var arrows;
            if (KTUtil.isRTL()) {
                    arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                    arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }
            $('#kt_datepicker_3').datepicker({
                format: "dd M yyyy",
                rtl: KTUtil.isRTL(),
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                templates: arrows,
            }).on('changeDate', function(e) {
                $("#kt_datepicker_3").attr('data-selected', e.format("yyyy-mm-dd"));
            });
        }
    }

    return {
        init: function() {
            dt();
        }
    };
}();

jQuery(document).ready(function() {
    KTBootstrapDaterangepicker.init();
});
