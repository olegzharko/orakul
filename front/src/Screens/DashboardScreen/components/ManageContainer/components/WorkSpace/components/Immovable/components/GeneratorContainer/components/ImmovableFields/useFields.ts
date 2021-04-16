import { useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useMemo, useState, useEffect } from 'react';
import { State } from '../../../../../../../../../../../../store/types';
import reqImmovableGeneral from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableGeneral';
import reqImmovableExchange from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableExchange';
import reqImmovableSellerBan from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableSellerBan';
import reqImmovableOwnership from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableOwnership';
import reqImmovablePayment from '../../../../../../../../../../../../services/generator/Immovable/reqImmovablePayment';
import reqImmovableRating from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableRating';
import reqImmovableTemplate from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableTemplate';

export const useFields = () => {
  const { token } = useSelector((state: State) => state.main.user);
  const { immovableId } = useParams<{clientId: string, immovableId: string}>();

  // Fields Data
  const [general, setGeneral] = useState();
  const [sellerBan, setSellerBan] = useState();
  const [ownerShip, setOwnerShip] = useState();
  const [securityPayment, setSecurityPayment] = useState();
  const [retting, setRetting] = useState();
  const [templates, setTemplates] = useState();

  const isCorrectId = useMemo(() => !Number.isNaN(parseFloat(immovableId)), [immovableId]);

  useEffect(() => {
    if (token && isCorrectId) {
      // get GENERAL
      (async () => {
        const res = await reqImmovableGeneral(token, immovableId);

        if (res?.success) {
          setGeneral(res.data);
        }
      })();

      // get SELLER_BAN
      (async () => {
        const res = await reqImmovableSellerBan(token, immovableId);

        if (res?.success) {
          setSellerBan(res.data);
        }
      })();

      // get OWNERSHIP
      (async () => {
        const res = await reqImmovableOwnership(token, immovableId);

        if (res?.success) {
          setOwnerShip(res.data);
        }
      })();

      // get SECURITY_PAYMENT
      (async () => {
        const res = await reqImmovablePayment(token, immovableId);

        if (res?.success) {
          setSecurityPayment(res.data);
        }
      })();

      // get RATING
      (async () => {
        const res = await reqImmovableRating(token, immovableId);

        if (res?.success) {
          setRetting(res.data);
        }
      })();

      // get TEMPLATES
      (async () => {
        const res = await reqImmovableTemplate(token, immovableId);

        if (res?.success) {
          setTemplates(res.data);
        }
      })();
    }
  }, [token, isCorrectId]);

  return {
    general,
    immovableId,
    sellerBan,
    ownerShip,
    securityPayment,
    retting,
    templates,
  };
};
