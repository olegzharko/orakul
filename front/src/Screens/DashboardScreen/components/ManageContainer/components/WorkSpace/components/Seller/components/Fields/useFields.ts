import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useMemo, useState, useEffect } from 'react';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../utils/formatDates';
import { State } from '../../../../../../../../../../store/types';
import reqDeveloper from '../../../../../../../../../../services/generator/Developer/reqDeveloper';
import postDeveloperFence from '../../../../../../../../../../services/generator/Developer/postDeveloperFence';
import { setModalInfo } from '../../../../../../../../../../store/main/actions';

type Developer = {
  title: string;
  color: string;
  info: {
    title: string;
    value: string;
  }[]
}

export const useFields = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { developerId, clientId } = useParams<{ developerId: string, clientId: string }>();

  const [developer, setDeveloper] = useState<Developer>();
  const [spouse, setSpouse] = useState([]);
  const [banData, setBanData] = useState({
    date: new Date(),
    number: '',
    pass: false,
  });

  const banDataSaveDisabled = useMemo(() => !banData.number || !banData.date, [banData]);
  const onBanDataSave = useCallback(async () => {
    if (token) {
      const data = {
        ...banData,
        date: formatDate(banData.date)
      };
      const res = await postDeveloperFence(token, developerId, clientId, 'POST', data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [token, developerId, clientId, banData]);

  useEffect(() => {
    const developerIsId = !Number.isNaN(parseFloat(developerId));
    if (token && developerIsId) {
      (async () => {
        const res = await reqDeveloper(token, developerId, clientId);

        if (res.success) {
          setDeveloper(res.data.dev_company);
          setSpouse(res.data.ceo_spouse_info);
          setBanData({
            ...res.data.dev_fence,
            date: res.data.dev_fence.date
              ? new Date(changeMonthWitDate(res.data.dev_fence.date)) : null,
          });
        }
      })();
    }
  }, [token]);

  return {
    developer,
    banData,
    banDataSaveDisabled,
    spouse,
    setBanData,
    onBanDataSave,
  };
};
