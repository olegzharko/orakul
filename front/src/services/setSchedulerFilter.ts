import { FilterData } from '../store/types';
import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function setSchedulerFilter(
  token: string,
  bodyData: FilterData
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/filter/sort`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'POST',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
