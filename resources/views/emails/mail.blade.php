<!DOCTYPE html>
<html>
<head>
<title>test</title>
</head>
<body>

    @if( $details['type'] == 'registraion')

        <p>Dear {{ $details['email'] }},</p>

        <p>Welcome to MyCATKing! </p>
        
        <p>You have successfully signed up and created an account with us. The login URL for MyCATKing is mycatking.com</p>
        <p>Username : {{ $details['username'] }}</p>
        <p>Password: {{ $details['password'] }}</p>
        
        <p>Complete your profile to get the Profile review from CATKing mentors. After exams, You can also use the same portal for Score Calculator and Personal Interview Preparation Dashboard. </p>
        
        <p>Visit the Announcement section to get all updates about the sessions and important notifications.</p>
        
        <p>If you have any questions, reach out to us at <a href="mailto:support@catking.in">support@catking.in</a> or call us on <a href="tel:8999-11-8999">8999-11-8999</a></p>
        <p>All the best!</p>
        <p>Team CATKing</p>
        
    @elseif( $details['type'] == 'otp')

        <p>Dear {{ $details['email'] }},</p>

        <p>We have received a request to change your password on MyCATKing portal. </p>

        <p>Your OTP (One-time Password) verification code is <b>{{ $details['otp'] }}</b>. Enter this code to reset your password. </p>

        <p>If you did not request for a reset, please let us know immediately by replying to <a href="mailto:support@catking.in">support@catking.in</a> , the team will take the necessary action.</p>

        <p>We are here to help you at any step along the way. For any concerns call us on <a href="tel:8999-11-8999">8999-11-8999</a></p>
        <p>All the best!</p>
        <p>Team CATKing</p>

    @elseif( $details['type'] == 'sop')

        <p>Dear {{ $details['email'] }},</p>

        <p>Your {{ $details['college'] }} SOP has been reviewed by our Mentors Team. </p>

        <p>
            To view your feedback, follow the below steps - 
            1. Login to your profile at www.mycatking.com
            2. From the left menu bar, click on the 'SOPs/Forms' section
            3. Go to {{ $details['college'] }} and click on 'View' button. 
            4. Your SOP feedback is now available on the View Review Section
        </p>

            <p>You are recommended to work on your SOP based on the mentor's feedback and submit it on the College Portal before the deadline.</p>

           <p> Make use of the Sample SOPs and Interview Preparation Videos on learn.catking.in to improve the Quality of SOP.</p>

            <p>Team CATKing wishes you All the best for all your exams and interview calls. </p>

           <p> If you have any questions, reach out to us at  <a href="mailto:support@catking.in">support@catking.in</a> or call us at <a href="tel:8999-11-8999">8999-11-8999</a></p>

            <p>Thanks,</p>
            <p>Team CATKing</p>
    @elseif( $details['type'] == 'profile')

        <p>Dear {{ $details['email'] }},</p>

        <p>Your profile has been reviewed by our expert mentor. </p>

            <p>To view your feedback, follow the below steps - </p>
            <ol>
                <li>Login to your profile at www.mycatking.com</li>
                <li>From the left menu bar, click on the 'Profile Feedback'</li>
                <li>Your Profile feedback is now available. </li>
            </ol>
            <p>You are recommended to work on your profile based on the mentor's feedback. </p>

            <p>Team CATKing wishes you All the best for all your exams and interview calls. </p>

            <p>If you have any questions, reach out to us at  <a href="mailto:support@catking.in">support@catking.in</a> or call us at <a href="tel:8999-11-8999">8999-11-8999</a>

            <p>Thanks,</p>
            <p>Team CATKing</p>
    @elseif( $details['type'] == 'interview')

        <p>Dear {{ $details['email'] }},</p>

        <p>Your CATKing Mock  Interview feedback has been provided by the interviewer on MyCATKing. </p>

        <p> 
            To view your feedback, follow the below steps - 
        </p>
        <ol>
            <li>Login to your profile at www.mycatking.com</li>
            <li>From the left menu bar, click on the 'Personal Interviews'</li>
            <li>Your Interview feedback is now available.</li>
        </ol>
        <p>You are recommended to work on your interview preparation based on the mentor's feedback.</p> 

        <p>Please make use of the complete IIMWATPI Dashboard to improve your interview answers.</p>

        <p>To get 1 additional interview, visit courses.catking.in </p>

        <p>Team CATKing wishes you All the best for all your exams and interview calls. </p>

        <p>If you have any questions, reach out to us at <a href="mailto:support@catking.in">support@catking.in</a> or call us at <a href="tel:8999-11-8999">8999-11-8999</p>

        <p>Thanks,</p>
        <p>Team CATKing</p>
            
    @endif

   

</body>
</html>