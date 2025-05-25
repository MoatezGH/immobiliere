@if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif