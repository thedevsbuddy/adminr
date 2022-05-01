<div class="py-3">
    <div class="d-flex justify-content-between align-items-center pr-4">
        <h3>Features settings</h3>
    </div>
    <hr>
    <form action="{{ route(config('app.route_prefix').'.settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="pr-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email_verification_enabled">Enable Email Verification</label>
                        <select name="email_verification_enabled" id="email_verification_enabled" class="form-control select2">
                            <option value="1" @if(getSetting('email_verification_enabled') == "1") selected @endif>Enabled</option>
                            <option value="0" @if(getSetting('email_verification_enabled') == "0") selected @endif>Disabled</option>
                        </select>
                        @if($errors->has('email_verification_enabled'))
                            <span class="text-danger">{{ $errors->first('email_verification_enabled') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_queue_enabled">Enable Email Queues</label>
                        <select name="mail_queue_enabled" id="mail_queue_enabled" class="form-control select2">
                            <option value="1" @if(getSetting('mail_queue_enabled') == "1") selected @endif>Enabled</option>
                            <option value="0" @if(getSetting('mail_queue_enabled') == "0") selected @endif>Disabled</option>
                        </select>
                        @if($errors->has('mail_queue_enabled'))
                            <span class="text-danger">{{ $errors->first('mail_queue_enabled') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="sendTestMailModal" tabindex="-1" aria-labelledby="sendTestMailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route(config('app.route_prefix').'.test-mail') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="sendTestMailModalLabel">Send Test Mail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Recipient's email address.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send mail</button>
                </div>
            </form>
        </div>
    </div>
</div>
