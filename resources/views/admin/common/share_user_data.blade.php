<div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-labelledby="modal-share" aria-hidden="true">
    <div class="modal-dialog modal-tertiary modal-dialog-centered modal-lg" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <button type="button" class="btn-close btn-close-white text-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="share-user-csv">
                <div class="modal-body text-center py-3">
                    <span class="modal-icon">
                        <svg class="icon icon-xl text-gray-200 mb-4" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <p class="mb-4 lead">Facilitate immediate access to downloadable CSV files containing user data to
                        streamline data management and analysis processes.</p>
                    <div class="form-group px-lg-5">
                        <div class="d-flex mb-3 justify-content-center">
                            {{-- <input type="email" id="share-email" class="me-sm-1 mb-sm-0 form-control form-control-lg"
                                placeholder="example@company.com"> --}}
                            <input
                                class="me-sm-1 mb-sm-0 form-control form-control-lg @error('email') is-invalid @enderror"
                                id="email" type="email" placeholder="user@yopmail.com" name="email"
                                id="share-email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div>
                                <button type="submit"
                                    class="ms-2 btn large-form-btn btn-secondary share-csv-btn">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer z-2 mx-auto text-center">
                <p class="text-white font-small">
                    We’ll never share your details with third parties.
                    <br class="visible-md">View our <a href="#">Privacy Policy</a> for more info.
                </p>
            </div>
        </div>
    </div>
</div>
