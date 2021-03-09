import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getToken() {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/login?email=oleg99@gmail.com&password=admin123`,
      method: 'POST',
    });

    return data.data.token;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
