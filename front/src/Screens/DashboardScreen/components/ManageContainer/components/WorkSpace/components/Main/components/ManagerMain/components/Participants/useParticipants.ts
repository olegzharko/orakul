import { useSelector, useDispatch } from 'react-redux';
import { useState, useCallback, useEffect } from 'react';
import putMainDeveloper from '../../../../../../../../../../../../services/manager/Main/putMainDeveloper';
import { ManagerParticipantsData } from '../../useManagerMain';
import { State } from '../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';
import getDeveloperInfo from '../../../../../../../../../../../../services/getDeveloperInfo';

export type Props = {
  initialData?: ManagerParticipantsData;
  cardId: string;
};

export const useParticipants = ({ initialData, cardId }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [firstRender, setFirstRender] = useState(true);
  const [representatives, setRepresentatives] = useState(initialData?.representative || []);
  const [manager, setManager] = useState(initialData?.manager || []);
  const [data, setData] = useState({
    developer_id: initialData?.developer_id || null,
    notary_id: initialData?.notary_id || null,
    representative_id: initialData?.representative_id || null,
    manager_id: initialData?.manager_id || null,
    generator_id: initialData?.generator_id || null,
    generation_ready: initialData?.generation_ready || false,
  });

  const onClear = useCallback(() => {
    setData({
      developer_id: null,
      notary_id: null,
      representative_id: null,
      manager_id: null,
      generator_id: null,
      generation_ready: false,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const res = await putMainDeveloper(token, cardId, data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [data, cardId, token]);

  useEffect(() => {
    if (firstRender) {
      setFirstRender(false);
      return;
    }

    if (token && data.developer_id) {
      (async () => {
        const res = await getDeveloperInfo(token, Number(data.developer_id));
        setData({ ...data, representative_id: null, manager_id: null });
        setRepresentatives(res.representative);
        setManager(res.manager);
      })();
    }
  }, [data.developer_id, token]);

  return {
    data,
    representatives,
    manager,
    setData,
    onClear,
    onSave,
  };
};
