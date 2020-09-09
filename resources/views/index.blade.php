<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Hello, world!</title>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="{{ asset('sketchpad/scripts/sketchpad.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('bootstrap-sweetalert/sweetalert.css') }}">
    <script src="{{ asset('bootstrap-sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
  </head>
  <body>
    
    <div class="card">
        <div class="card-header">
            Complete información
            <br>
            <label for="">Ingrese la firma<i class="text-danger">*</i></label>
        </div>
        
        <div class="card-body text-center text-info">
            <button class="btn btn-warning" onclick="remover()"><i class="icon-rotate-ccw3"></i> Remover Firma</button>
            <button type="button" onclick="procesarImagen(this);" class="btn btn-primary">{{ __('Actualizar') }} <i class="icon-paperplane ml-2"></i></button><br>
            <canvas id="sketchpad" class="border border-dark mt-2"></canvas>
        

            <img src="{{ $usuario->firma??'' }}" class="img-fluid img-thumbnail" alt="" >

         
        <br>
    </div>
    </div>
    

    <script>
         $('#menuUsuarios').addClass('active');
            
        var sketchpad = new Sketchpad({
            element: '#sketchpad',
            width: 600,
            height: 300,
        
        });
        function color() {
                sketchpad.color = "#0b62a7";
            }
            color();

        function procesarImagen(arg){
            var canvas = document.getElementById('sketchpad');
            var dataURL = canvas.toDataURL();
            
            swal({
                title: "¿Confirmación?",
                text: "Procesar firma.!",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "¡Sí, guardar!",
                cancelButtonText:"Cancelar",
                closeOnConfirm: false
            },
            function(){
                swal.close();
                
                $.post( "{{ route('procesarFirma') }}", {foto:dataURL })
                .done(function( data ) {
                    
                    console.log(data)
                }).always(function(){
                    
                }).fail(function(err){
                    
                    console.log(err)
                });

            });
        }

        function remover() {
        
            sketchpad.undo()
        }
    </script>
  </body>
</html>