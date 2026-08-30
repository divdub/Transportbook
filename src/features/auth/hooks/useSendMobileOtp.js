import {useState} from 'react';
import {mockSendMobileOtp} from '../auth.mock';

export function useSendMobileOtp() {
  const [isSending, setIsSending] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');

  const sendOtp = async mobileNumber => {
    setIsSending(true);
    setErrorMessage('');
    try {
      return await mockSendMobileOtp({mobileNumber});
    } catch (error) {
      setErrorMessage(error?.message || 'Unable to send OTP.');
      throw error;
    } finally {
      setIsSending(false);
    }
  };

  return {sendOtp, isSending, errorMessage};
}