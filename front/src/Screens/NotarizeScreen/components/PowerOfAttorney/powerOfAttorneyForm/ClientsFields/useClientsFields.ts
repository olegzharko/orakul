import { useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useState, useEffect, useMemo } from 'react';

import { State } from '../../../../../../store/types';
import reqClientName from '../../../../../../services/notarize/Client/reqClientName';
import reqClientCitizenship from '../../../../../../services/notarize/Client/reqClientCitizenship';
import reqClientPassport from '../../../../../../services/notarize/Client/reqClientPassport';
import reqClientAddress from '../../../../../../services/notarize/Client/reqClientAddress';
import { isNumber } from '../../../../../../utils/numbers';

interface ClientsFieldsProps {
  clientType: string;
}

export const useClientsFields = ({ clientType }: ClientsFieldsProps) => {
  const { token } = useSelector((state: State) => state.main.user);
  const { lineItemId, personId, id } = useParams<{
    lineItemId: string, personId: string, id: string
  }>();
  const [userType, setUserType] = useState();
  // Fields Data
  const [fioData, setFioData] = useState();
  const [citizenship, setCitizenship] = useState();
  const [passport, setPassport] = useState();
  const [address, setAddress] = useState();

  const isCorrectId = useMemo(() => isNumber(id), [id]);

  useEffect(() => {
    if (token && isCorrectId) {
      // get FIO
      (async () => {
        const res = await reqClientName(token, clientType, id);

        if (res?.success) {
          setFioData(res.data);
          setUserType(res.data.type);
        }
      })();

      // get CITIZENSHIP
      (async () => {
        const { success, data } = await reqClientCitizenship(token, clientType, id);

        if (success) {
          setCitizenship(data);
        }
      })();

      // get PASSPORT
      (async () => {
        const { success, data } = await reqClientPassport(token, clientType, id);

        if (success) {
          setPassport(data);
        }
      })();

      // get ADDRESS
      (async () => {
        const { success, data } = await reqClientAddress(token, clientType, id);

        if (success) {
          setAddress(data);
        }
      })();
    }
  }, [token, id, isCorrectId]);

  return {
    userType,
    lineItemId,
    personId,
    fioData,
    citizenship,
    passport,
    address,
  };
};
