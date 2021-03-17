import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getLoginCarouselImages(token: string) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/slides`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data.data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
