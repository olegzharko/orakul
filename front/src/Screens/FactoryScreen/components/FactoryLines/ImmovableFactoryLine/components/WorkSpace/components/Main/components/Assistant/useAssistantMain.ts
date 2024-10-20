import { data } from 'jquery';
import { useSelector, useDispatch } from 'react-redux';
import { useEffect, useState, useCallback, useMemo } from 'react';
import { useParams } from 'react-router-dom';

import { State } from '../../../../../../../../../../../store/types';
import reqAssistantMain from '../../../../../../../../../../../services/assistant/reqAssistantMain';
import getDeveloperInfo from '../../../../../../../../../../../services/getDeveloperInfo';
import { setModalInfo } from '../../../../../../../../../../../store/main/actions';

type General = {
  notary_id: string | null,
  developer_id: string | null,
  representative_id: string | null,
  manager_id: string | null,
  reader_id: string | null,
  generator_id: string | null,
  cancelled: boolean,
}

type Immovable = {
  [key: string]: string | null;
}

export const useAssistantMain = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { lineItemId } = useParams<{lineItemId: string}>();

  const [title, setTitle] = useState('');

  // selects
  const [notary, setNotary] = useState([]);
  const [developer, setDeveloper] = useState([]);
  const [representative, setRepresentative] = useState([]);
  const [manager, setManager] = useState([]);
  const [reader, setReader] = useState([]);
  const [accompanying, setAccompanying] = useState([]);
  const [generator, setGenerator] = useState([]);

  // data
  const [general, setGeneral] = useState<General>({
    notary_id: null,
    developer_id: null,
    representative_id: null,
    manager_id: null,
    reader_id: null,
    generator_id: null,
    cancelled: false,
  });
  const [immovables, setImmovables] = useState<Immovable[]>([]);

  const onImmovableChange = useCallback((index: number, key: string, value: any) => {
    immovables[index][key] = value;
    setImmovables([...immovables]);
  }, [immovables]);

  const onGeneralClear = useCallback(() => {
    setGeneral({
      notary_id: null,
      developer_id: null,
      representative_id: null,
      manager_id: null,
      reader_id: null,
      generator_id: null,
      cancelled: false,
    });
  }, []);

  const onImmovableClear = useCallback((index: number) => {
    setImmovables((prev) => prev.map((item, i) => {
      if (index === i) {
        return {
          ...item,
          accompanying_id: null,
          reader_id: null,
        };
      }

      return item;
    }));
  }, []);

  const onSave = useCallback(async () => {
    const bodyData = {
      ...general,
      immovables
    };

    if (token) {
      const res = await reqAssistantMain(token, lineItemId, 'PUT', bodyData);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [general, immovables, token, lineItemId, dispatch]);

  const isSaveButtonDisabled = useMemo(() => !general.developer_id
    || !general.notary_id, [general.developer_id, general.notary_id]);

  const onDeveloperChange = useCallback(async (id: string) => {
    if (token) {
      const res = await getDeveloperInfo(token, Number(id));
      setGeneral(
        (prev) => ({ ...prev, representative_id: null, manager_id: null, developer_id: id })
      );
      setRepresentative(res.representative);
      setManager(res.manager);
    }
  }, [token]);

  useEffect(() => {
    if (token) {
    // GET DATA FOR ASSISTANT
      (async () => {
        const res = await reqAssistantMain(token, lineItemId);

        if (res?.success) {
          const { day, date, time, room } = res?.data.date_info;
          setTitle(`${day} ${date} ${time} ${room}`);

          setNotary(res?.data.notary || []);
          setDeveloper(res?.data.developer || []);
          setRepresentative(res?.data.representative || []);
          setManager(res?.data.manager || []);
          setReader(res?.data.reader || []);
          setAccompanying(res?.data.accompanying || []);
          setGenerator(res?.data.generator || []);

          setGeneral({
            notary_id: res?.data.notary_id || null,
            developer_id: res?.data.developer_id || null,
            representative_id: res?.data.representative_id || null,
            manager_id: res?.data.manager_id || null,
            reader_id: res?.data.reader_id || null,
            generator_id: res?.data.generator_id || null,
            cancelled: res?.data.cancelled,
          });

          setImmovables(res?.data.immovables);
        }
      })();
    }
  }, [token, lineItemId]);

  return {
    title,
    notary,
    developer,
    representative,
    manager,
    reader,
    accompanying,
    generator,
    general,
    immovables,
    isSaveButtonDisabled,
    setGeneral,
    setImmovables,
    onImmovableChange,
    onGeneralClear,
    onImmovableClear,
    onSave,
    onDeveloperChange,
  };
};
