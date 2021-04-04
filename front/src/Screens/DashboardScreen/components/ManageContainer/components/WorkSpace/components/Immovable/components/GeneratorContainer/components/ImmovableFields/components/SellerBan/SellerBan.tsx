import * as React from 'react';
import CheckBanFields from '../../../../../../../../../../../../../../components/CheckBanFields';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import { useSellerBan } from './useSellerBan';

const SellerBan = () => {
  const meta = useSellerBan();

  return (
    <>
      <CheckBanFields data={meta.initialData} setData={meta.setData} title="Заборони на продавця" />
      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
      </div>
    </>
  );
};

export default SellerBan;
