import React, { useState } from 'react';
import AddFormButton from '../../../../../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import AddCityModal from './AddCityModal';

const Address = () => {
  const [showModal, setShowModal] = useState<boolean>(false);

  return (
    <div className="clients__address">
      <SectionWithTitle title="Адреса" onClear={() => console.log('clear')}>
        <div className="clients__address-container">
          <CustomSelect label="Область" data={[]} onChange={(e) => console.log(e)} />
        </div>

        <div className="clients__address-container">
          <CustomSelect label="Район або територіальна громада" data={[]} onChange={(e) => console.log(e)} />
        </div>

        <div className="clients__address-container df">
          <CustomSelect label="Населений пункт" data={[]} onChange={(e) => console.log(e)} />
          <div className="add-button">
            <AddFormButton onClick={() => setShowModal(true)} />
          </div>
        </div>

        <div className="clients__address-container df duet">
          <div className="short-width">
            <CustomSelect label="Тип вулиці" data={[]} onChange={(e) => console.log(e)} />
          </div>
          <div className="long-width">
            <CustomInput label="Назва вулиці" onChange={(e) => console.log(e)} />
          </div>
        </div>

        <div className="clients__address-container df duet">
          <div className="long-width">
            <CustomSelect label="Тип будинку" data={[]} onChange={(e) => console.log(e)} />
          </div>
          <div className="short-width">
            <CustomInput label="Номер будинку" onChange={(e) => console.log(e)} />
          </div>
        </div>

        <div className="clients__address-container df duet">
          <div className="long-width">
            <CustomSelect label="Тип приміщення" data={[]} onChange={(e) => console.log(e)} />
          </div>
          <div className="short-width">
            <CustomInput label="Номер приміщення" onChange={(e) => console.log(e)} />
          </div>
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
      </div>

      <AddCityModal open={showModal} onClose={setShowModal} />
    </div>
  );
};

export default Address;
