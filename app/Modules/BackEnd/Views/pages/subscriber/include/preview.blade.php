<div class="modal fade bs-example-modal-center" id="formDetailInfo" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="col-xl-12">
                <div class="card-box">
                    <div class="media mb-3">
                        <img class="d-flex mr-3 rounded-circle avatar-lg" src="{{ admin_link('/images/users/user-8.jpg') }}" alt="{{ @$obj['fullname'] }}">
                        <div class="media-body">
                            <h4 class="mt-0 mb-1">Họ tên: {{ @$obj['fullname'] }}</h4>
                            <p class="text-muted mb-2">Số điện thoại: {{ @$obj['phone'] }}</p>
                            <p class="text-muted">Email: {{ @$obj['email'] }}</p>

                            <a href="mailto:{{ @$obj['email'] }}" class="btn- btn-xs btn-info">Send Email</a>
                            <a href="tel:{{ @$obj['phone'] }}" class="btn- btn-xs btn-secondary">Call</a>
                        </div>
                    </div>
                    <div class="">
                        <h4 class="font-13 text-muted text-uppercase">Thông tin thêm :</h4>
                        <p class="mb-3">
                            {{ @$obj['address']?:@$obj['content'] }}
                        </p>

                    </div>

                </div> <!-- end card-box-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    document.getElementById("invoice-print").onclick = function () {
        printElement(document.getElementById("invoice-content"));
    };

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }
</script>
<style>
    @media screen {
    #printSection {
        display: none;
    }
    }

    @media print {
    body * {
        visibility:hidden;
    }
    #printSection, #printSection * {
        visibility:visible;
    }
    #printSection {
        position:absolute;
        left:0;
        top:0;
    }
    }
</style>