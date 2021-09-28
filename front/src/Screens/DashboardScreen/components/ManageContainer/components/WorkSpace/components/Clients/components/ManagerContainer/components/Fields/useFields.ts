import { useParams, useHistory } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { useEffect, useCallback, useState, useMemo } from 'react';

import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../../../../../../../constants';

import { SelectItem } from '../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../store/types';
import reqManagerClient from '../../../../../../../../../../../../services/manager/Clients/reqManagerClient';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';
import { isNumber } from '../../../../../../../../../../../../utils/numbers';

export const useFields = () => {
  const history = useHistory();
  const dispatch = useDispatch();

  const { token } = useSelector((state: State) => state.main.user);
  const { clientId, personId } = useParams<{clientId: string, personId: string}>();

  // Selects
  const [marriedTypes, setMarriedTypes] = useState<SelectItem[]>([]);
  const [passportTypes, setPassportTypes] = useState<SelectItem[]>([]);

  // Fields Data
  const [client, setClient] = useState<any>({});
  const [clientChecks, setClientChecks] = useState<any>([]);
  const [general, setGeneral] = useState<any>({});
  const [spouse, setSpouse] = useState<any>({});
  const [spouseChecks, setSpouseChecks] = useState<any>([]);
  const [confidant, setConfidant] = useState<any>({});
  const [confidantChecks, setConfidantChecks] = useState<any>([]);

  const onClientChecksChange = useCallback((index: number, value: boolean) => {
    clientChecks[index].value = value;
    setClientChecks([...clientChecks]);
  }, [clientChecks]);

  const onSpouseChecksChange = useCallback((index: number, value: boolean) => {
    spouseChecks[index].value = value;
    setSpouseChecks([...spouseChecks]);
  }, [spouseChecks]);

  const onConfidantChecksChange = useCallback((index: number, value: boolean) => {
    confidantChecks[index].value = value;
    setConfidantChecks([...confidantChecks]);
  }, [confidantChecks]);

  const onClientClear = useCallback(() => {
    const clearClient: any = {};
    Object.keys(client).forEach((item: string) => {
      if (typeof client[item] === 'boolean') {
        clearClient[item] = false;
      } else {
        clearClient[item] = '';
      }
    });
    setClient(clearClient);
    setClientChecks((prev: any) => prev.map((item: any) => {
      item.value = false;
      return item;
    }));
  }, [client]);

  const onSpouseClear = useCallback(() => {
    const clearSpouse: any = {};
    Object.keys(spouse).forEach((item: string) => {
      clearSpouse[item] = '';
    });
    setSpouse(clearSpouse);
    setSpouseChecks((prev: any) => prev.map((item: any) => {
      item.value = false;
      return item;
    }));
  }, [spouse]);

  const onConfidantClear = useCallback(() => {
    const clearConfidant: any = {};
    Object.keys(confidant).forEach((item: string) => {
      clearConfidant[item] = '';
    });
    setConfidant(clearConfidant);
    setConfidantChecks((prev: any) => prev.map((item: any) => {
      item.value = false;
      return item;
    }));
  }, [confidant]);

  const onSave = useCallback(async () => {
    if (token) {
      // format clientsChecks for request
      const clientChecksValues: any = {};
      clientChecks.forEach((item: any) => {
        clientChecksValues[item.key] = item.value;
      });

      // format spouseChecks for request
      const spouseChecksValues: any = {};
      spouseChecks.forEach((item: any) => {
        spouseChecksValues[item.key] = item.value;
      });

      // format confidantChecks for request
      const confidantChecksValues: any = {};
      confidantChecks.forEach((item: any) => {
        confidantChecksValues[item.key] = item.value;
      });

      const bodyData = {
        client: {
          data: client,
          info: clientChecksValues,
        },
        spouse: {
          data: spouse,
          info: spouseChecksValues,
        },
        representative: {
          data: confidant,
          info: confidantChecksValues,
        }
      };

      const res = await reqManagerClient(token, clientId, personId, 'PUT', bodyData);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );

      if (res?.success && personId === 'create' && isNumber(res?.data.client_id)) {
        history.push(`${MANAGE_CONTAINER_LINK_PREFIX}/clients/${clientId}/${res?.data.client_id}`);
      }
    }
  }, [
    token,
    clientChecks,
    spouseChecks,
    confidantChecks,
    client,
    spouse,
    confidant,
    clientId,
    personId,
    dispatch,
    history,
  ]);

  const isSaveButtonDisabled = useMemo(() => !client.name
    || !client.surname
    || !client.passport_type_id, [client.name, client.surname, client.passport_type_id]);

  useEffect(() => {
    if (token) {
      // get CLIENT_DATA
      (async () => {
        const res = await reqManagerClient(token, clientId, personId);

        if (res?.success) {
          setClient(res?.data.client.data || {
            surname: '',
            name: '',
            patronymic: '',
            phone: '',
            email: '',
            married_type_id: null,
            passport_type_id: null,
            previous_buyer: false,
          });
          setClientChecks(res?.data.client.info);
          setSpouse(res?.data.spouse.data || {
            surname: '',
            name: '',
            patronymic: '',
          });
          setSpouseChecks(res?.data.spouse.info);
          setConfidant(res?.data.confidant.data || {
            surname: '',
            name: '',
            patronymic: '',
          });
          setConfidantChecks(res?.data.confidant.info);
          setMarriedTypes(res?.data.married_types || []);
          setPassportTypes(res?.data.passport_type || []);
        }
      })();
    }
  }, [token, personId, clientId]);

  return {
    clientId,
    personId,
    client,
    clientChecks,
    general,
    spouse,
    spouseChecks,
    confidant,
    confidantChecks,
    marriedTypes,
    passportTypes,
    isSaveButtonDisabled,
    setClient,
    setGeneral,
    setSpouse,
    setConfidant,
    onClientChecksChange,
    onSpouseChecksChange,
    onConfidantChecksChange,
    onClientClear,
    onSpouseClear,
    onConfidantClear,
    onSave,
  };
};
