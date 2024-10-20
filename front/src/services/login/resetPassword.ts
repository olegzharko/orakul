import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export type ResetPasswordType = {
  token: string;
  email: string;
  password: string;
  c_password: string;
};

export default async function resetPassword(bodyData: ResetPasswordType) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/password/update`,
      method: 'POST',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
