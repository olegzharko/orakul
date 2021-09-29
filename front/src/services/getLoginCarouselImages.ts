import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getLoginCarouselImages() {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/slides`,
    });

    return data.data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
