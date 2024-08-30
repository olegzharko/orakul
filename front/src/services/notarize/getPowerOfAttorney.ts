import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export default async function getPowerOfAttorney(token: string) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/notarize/power-of-attorneys`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
