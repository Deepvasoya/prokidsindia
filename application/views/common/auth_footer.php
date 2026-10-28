<!-- Student Login start-->
<div id="studentLogin" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner text-center">
            <h4 class="edu_admin_title edu_logt_title"></h4>
            <h6 class="edu_admin_sub_title edu_logt_title"><?php echo html_escape($this->common->languageTranslator('ltr_already_logout'));?></h6>
            <input type="hidden" value="<?php echo base_url();?>" id="base_url">
             <button type="button" class="edu_btn changeStudentLogin mb-2" data-id=""><?php echo html_escape($this->common->languageTranslator('ltr_yes'));?></button>
             <button type="button" class="edu_btn edu_btn_black PopupCancelBtn ml-2 mb-2"><?php echo html_escape($this->common->languageTranslator('ltr_cancel'));?></button>
        </div>
    </div>
</div>
<!-- Login end-->
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/toastr.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/login.js?<?php echo time();?>"></script>
    <script src="<?php echo base_url();?>assets/js/valid.js?<?php echo time();?>"></script>
    
    <script>
    
    
            function generateUniqueId() {
    const randomPart = () => Math.random().toString(36).substr(2, 9);
    const timestamp = new Date().getTime();
    const userAgent = navigator.userAgent.replace(/[^a-zA-Z0-9-_]/g, '');
    const platform = navigator.platform.replace(/[^a-zA-Z0-9-_]/g, '');
    const screenResolution = `${screen.width}x${screen.height}`.replace(/[^a-zA-Z0-9-_]/g, '');

    // Generate the unique ID
    const uniqueId = `${userAgent}_${platform}_${screenResolution}`;

    // Use only letters, digits, dashes, and underscores
    const formattedId = uniqueId.replace(/[^a-zA-Z0-9-_]/g, '');

    // Append the formatted ID to device_id
    const deviceId = `device_id_${formattedId}`;

    return deviceId;
        }

        function getDeviceId() {
            const deviceId = generateUniqueId();
            localStorage.setItem('deviceId', deviceId);
            document.cookie = `deviceId=${deviceId}; path=/`;
            return deviceId;
        }

        $(document).ready(function() {
            $('#device_id').val(getDeviceId());
        });
    </script>
    
  
</body>
</html>