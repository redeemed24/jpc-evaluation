			</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Morris Charts JavaScript -->


    {!! Html::script('../resources/assets/js/jquery.js') !!}
    {!! Html::script('../resources/assets/js/bootstrap.min.js') !!}
    {!! Html::script('../resources/assets/js/plugins/morris/raphael.min.js') !!}
    {!! Html::script('../resources/assets/js/plugins/morris/morris.min.js') !!}
    {{-- {!! Html::script('../resources/assets/js/plugins/morris/morris-data.js') !!} --}}


    {!! Html::script('../resources/assets/js/dataTable.js') !!}
	{!! Html::script('../resources/assets/js/bootstrap-data-table.js') !!}

    {!! Html::script('../resources/assets/js/bootstrap-datepicker.js') !!}
    {!! Html::script('../resources/assets/js/timepicker.min.js') !!}
    {!! Html::script('../resources/assets/js/Chart.js') !!}

   
</body>

<script type="text/javascript">
	$('.table-striped').dataTable({
        "order": [],
    });

    $('.delete-form').on('submit',function (e) {
        

        if (confirm("Are you sure to delete this data?")) {
            return true;
        }else{
            e.preventDefault();
            return false;
        };

    });

    $('#timepicker').timepicker();

</script>

</html>