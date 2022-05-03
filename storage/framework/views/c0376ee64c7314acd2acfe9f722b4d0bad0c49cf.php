<!DOCTYPE html>
<html>
<head>
    <title>Neo Stats</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link id="bs-css" href="https://netdna.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

</head>
    
<body>
  
    <div class="container">
        <div class="card">
               <div class="card-header text-center font-weight-bold">
                 Chart
               </div>
            <div class="card-body">
                <form name="neoform" id="neoform" method="post" action="<?php echo e(route('chart.filter')); ?>">
                <?php echo csrf_field(); ?>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="datetimepicker1">Start Date</label>
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control" name="start_date" value="<?php echo e(old('start_date')); ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <small style="color:red"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="datetimepicker2">End Date</label>
                        <div class='input-group date' id='datetimepicker2' >
                            <input type='text' class="form-control" name="end_date" value="<?php echo e(old('end_date')); ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small style="color:red"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col-md-12">
                 <button type="submit" class="btn btn-primary">Submit</button>
                </div>
               </form>
            </div>
        </div>


        <canvas id="myChart" height="100px"></canvas>
    </div>
  
    
   

</body>
</html>

  


<script type="text/javascript">

      var labels =  <?php echo e(Js::from($labels)); ?>;
      var users =  <?php echo e(Js::from($data)); ?>;
  
      const data = {
        labels: labels,
        datasets: [{
          label: 'Near Earth Objects by date ',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: users,
        }]
      };
  
      const config = {
        type: 'line',
        data: data,
        options: {}
      };
  
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
  

    $(function () {
        $('#datetimepicker1,#datetimepicker2').datepicker({
            format: "yyyy-mm-dd",
            weekStart: 0,
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true, 
            orientation: "auto"
        });
        
    });
</script>
</html><?php /**PATH C:\xampp\htdocs\neoStats\resources\views/charts.blade.php ENDPATH**/ ?>