import { useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useState, useEffect, useMemo } from 'react';
import { State } from '../../../../../../../../../../../../store/types';
import reqClientName from '../../../../../../../../../../../../services/generator/Client/reqClientName';
import reqClientContacts from '../../../../../../../../../../../../services/generator/Client/reqClientContacts';
import reqClientCitizenship from '../../../../../../../../../../../../services/generator/Client/reqClientCitizenship';
import reqClientPassport from '../../../../../../../../../../../../services/generator/Client/reqClientPassport';
import reqClientAddress from '../../../../../../../../../../../../services/generator/Client/reqClientAddress';
import reqClientConsents from '../../../../../../../../../../../../services/generator/Client/reqClientConsents';
import reqClientRepresentative from '../../../../../../../../../../../../services/generator/Client/reqClientRepresentative';

export const useClientsFields = () => {
  const { token } = useSelector((state: State) => state.main.user);
  const { clientId, personId } = useParams<{clientId: string, personId: string}>();

  const [userType, setUserType] = useState();
  // Fields Data
  const [fioData, setFioData] = useState();
  const [contacts, setContacts] = useState();
  const [citizenship, setCitizenship] = useState();
  const [passport, setPassport] = useState();
  const [address, setAddress] = useState();
  const [consents, setConsents] = useState();
  const [representative, setRepresentative] = useState();

  const isCorrectId = useMemo(() => !Number.isNaN(parseFloat(personId)), [personId]);

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

      // get CONSENTS
      (async () => {
        const { success, data } = await reqClientConsents(token, clientId, personId);

        if (success) {
          setConsents(data);
        }
      })();

      // get REPRESENTATIVE
      (async () => {
        const { success, data } = await reqClientRepresentative(token, clientId, personId);

        if (success) {
          setRepresentative(data);
        }
      })();
    }
  }, [token, clientId, personId, isCorrectId]);

  return {
    userType,
    clientId,
    personId,
    fioData,
    contacts,
    citizenship,
    passport,
    address,
    consents,
    representative,
  };
};
