export const mockRequestLoginOtp = async ({mobileNumber}) => {
  await delay(450);

  return {
    mobileNumber,
    mode: 'mock_otp_requested',
  };
};

export const mockCompleteOtpAuthentication = async ({mobileNumber}) => {
  await delay(450);

  return {
    mode: 'mock_authenticated_session',
    mobileNumber,
  };
};

const delay = ms => new Promise(resolve => setTimeout(resolve, ms));
