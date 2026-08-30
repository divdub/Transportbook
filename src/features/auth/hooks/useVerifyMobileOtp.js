import {useState} from 'react';
import {mockVerifyMobileOtp} from '../auth.mock';

export function useVerifyMobileOtp() {
  const [isVerifying, setIsVerifying] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');

  const verifyOtp = async (mobileNumber, otp) => {
    setIsVerifying(true);
    setErrorMessage('');
    try {
      return await mockVerifyMobileOtp({mobileNumber, otp});
    } catch (error) {
      setErrorMessage(error?.message || 'Unable to verify OTP.');
      throw error;
    } finally {
      setIsVerifying(false);
    }
  };

  return {verifyOtp, isVerifying, errorMessage};
}