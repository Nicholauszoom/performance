<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
            Performance Details </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <div class="modal-body">


        <table id="datatable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Performance</th>
                    <th>Behavior</th>

                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @if (count($data) > 0)
                    @for ($i = 0; $i < count($data); $i++)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $data[$i]['full_name'] }}</td>
                            <td>{{ $data[$i]['department'] }}</td>
                            <td>1</td>
                            <td>2</td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>


    <div class="modal-footer ">
        <button class="btn btn-primary" type="submit" id="save"><i
                class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
            Close</button>
    </div>



</div>
</div>
