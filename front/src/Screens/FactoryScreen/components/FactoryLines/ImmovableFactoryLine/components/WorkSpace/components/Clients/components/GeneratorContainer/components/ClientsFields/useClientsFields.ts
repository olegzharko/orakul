import { useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useState, useEffect, useMemo } from 'react';

import { State } from '../../../../../../../../../../../../../store/types';
import reqClientName from '../../../../../../../../../../../../../services/generator/Client/reqClientName';
import reqClientContacts from '../../../../../../../../../../../../../services/generator/Client/reqClientContacts';
import reqClientWork from '../../../../../../../../../../../../../services/generator/Client/reqClientWork';
import reqClientCitizenship from '../../../../../../../../../../../../../services/generator/Client/reqClientCitizenship';
import reqClientPassport from '../../../../../../../../../../../../../services/generator/Client/reqClientPassport';
import reqClientAddress from '../../../../../../../../../../../../../services/generator/Client/reqClientAddress';
import reqNativeClientAddress from '../../../../../../../../../../../../../services/generator/Client/reqNativeClientAddress';
import reqClientConsents from '../../../../../../../../../../../../../services/generator/Client/reqClientConsents';
import reqClientRepresentative from '../../../../../../../../../../../../../services/generator/Client/reqClientRepresentative';
import reqTermination from '../../../../../../../../../../../../../services/generator/Client/reqTermination';
import { isNumber } from '../../../../../../../../../../../../../utils/numbers';

export const useClientsFields = () => {
  const { token } = useSelector((state: State) => state.main.user);
  const { lineItemId, personId } = useParams<{lineItemId: string, personId: string}>();

  const [userType, setUserType] = useState();
  // Fields Data
  const [fioData, setFioData] = useState();
  const [contacts, setContacts] = useState();
  const [work, setWork] = useState();
  const [citizenship, setCitizenship] = useState();
  const [passport, setPassport] = useState();
  const [address, setAddress] = useState();
  const [native_address, setNativeAddress] = useState();
  const [consents, setConsents] = useState();
  const [representative, setRepresentative] = useState();
  const [termination, setTermination] = useState();

  const isCorrectId = useMemo(() => isNumber(personId), [personId]);

  useEffect(() => {
    if (token && isCorrectId) {
      // get FIO
      (async () => {
        const res = await reqClientName(token, '', personId);

        if (res?.success) {
          setFioData(res.data);
          setUserType(res.data.type);
        }
      })();

      // get CONTACTS
      (async () => {
        const { success, data } = await reqClientContacts(token, personId);

        if (success) {
          setContacts(data);
        }
      })();

      // get WORK
      (async () => {
        const { success, data } = await reqClientWork(token, personId);

        if (success) {
          setWork(data);
        }
      })();

      // get CITIZENSHIP
      (async () => {
        const { success, data } = await reqClientCitizenship(token, personId);

        if (success) {
          setCitizenship(data);
        }
      })();

      // get PASSPORT
      (async () => {
        const { success, data } = await reqClientPassport(token, personId);

        if (success) {
          setPassport(data);
        }
      })();

      // get ADDRESS
      (async () => {
        const { success, data } = await reqClientAddress(token, personId);

        if (success) {
          setAddress(data);
        }
      })();

      // get ADDRESS
      (async () => {
        const { success, data } = await reqNativeClientAddress(token, personId);

        if (success) {
          setNativeAddress(data);
        }
      })();

      // get CONSENTS
      (async () => {
        const { success, data } = await reqClientConsents(token, lineItemId, personId);

        if (success) {
          setConsents(data);
        }
      })();

      // get REPRESENTATIVE
      (async () => {
        const { success, data } = await reqClientRepresentative(token, lineItemId, personId);

        if (success) {
          setRepresentative(data);
        }
      })();

      // get TERMINATION
      (async () => {
        const { success, data } = await reqTermination(token, lineItemId, personId);

        if (success) {
          setTermination(data);
        }
      })();
    }
  }, [token, lineItemId, personId, isCorrectId]);

  return {
    userType,
    lineItemId,
    personId,
    fioData,
    contacts,
    work,
    citizenship,
    passport,
    address,
    native_address,
    consents,
    representative,
    termination,
  };
};
