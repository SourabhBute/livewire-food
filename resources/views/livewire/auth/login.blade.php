<div class="container mt-5">
    <div class="row signin-margin">
            <div class="col-lg-4 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-warning border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                            <div class="row mt-3">
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent='store'>

                            @if (Session::has('status'))
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <div class="input-group input-group-outline mt-5 mb-1 @if(strlen($email ?? '') > 0) is-filled @endif">
                                <label class="form-label">Email / Phone</label>
                                <input wire:model='email' type="text" class="form-control">
                            </div>
                            @error('email')
                            <p class='text-danger inputerror mb-1'>{{ $message }} </p>
                            @enderror

                            <div class="input-group input-group-outline mt-4 mb-1  @if(strlen($password ?? '') > 0) is-filled @endif">
                                <label class="form-label">Password</label>
                                <input wire:model="password" type="password" id="pwd" class="form-control rounded-3">
                                <a class="material-symbols-outlined password-visibility"  onclick="showHidePassword('pwd', this)" aria-hidden="true">
                                    visibility_off
                                </a>
                            </div>
                            @error('password')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                           
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark  btn-lg w-100 my-4 mb-2">Sign
                                    in</button>
                            </div>
                            
                            <p class="text-sm text-center">
                                Forgot your password? Reset your password
                                <a href="{{ route('forget-password') }}"
                                    class="text-dark  text-gradient font-weight-bold">here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
<script>
    $(function () {

        var input = $(".input-group input");
        input.focusin(function () {
            $(this).parent().addClass("focused is-focused");
        });

        input.focusout(function () {
            $(this).parent().removeClass("focused is-focused");
        });
    });

</script>

<script>
    function showHidePassword(id, element) {
     let x = document.getElementById(id);
      if (x.type === "password") {
            x.type = "text";
            element.innerHTML='visibility';
      } else {
            x.type = "password";
            element.innerHTML='visibility_off';
      }
    }
</script>
@endpush

