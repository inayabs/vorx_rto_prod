<template>
    <div>

        <div class="row mb-2 d-flex">
            <div class="col-md-6">
                <a href="/email-sending" class="btn btn-primary btn-sm text-primary text-light"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary d-flex align-content-center justify-content-between">
                    <span>{{ $data.findEmailSending.subject  }} - {{ $data.findEmailSending.created_at }}</span>
                    <span><i class="fas fa-paperclip"></i> {{ $data.findEmailSending.attachments.split(',').length }}</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered table-hover m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Email Address</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Snow</td>
                                    <td>john_snow69@gmail.com</td>
                                    <td>Success</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            findEmailSending: find_email_sending,
        }
    }
}
</script>