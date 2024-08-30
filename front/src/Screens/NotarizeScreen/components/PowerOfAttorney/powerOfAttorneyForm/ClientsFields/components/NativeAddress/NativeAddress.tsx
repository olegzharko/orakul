import React from 'react';

import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../components/SectionWithTitle';

import AddCityModal from './components/AddCityModal';
import Fields from './components/Fields';
import { useNativeAddress, Props } from './useNativeAddress';

const NativeAddress = (props: Props) => {
  const meta = useNativeAddress(props);

  return (
    <div className="clients__address">
      <SectionWithTitle title="Місце народження" onClear={meta.onClear}>
        <div className="clients__address-fields">
          <Fields
            regions={meta.regions}
            cities={meta.cities}
            districts={meta.districts}
            addressType={meta.addressType}
            buildingType={meta.buildingType}
            buildingPartType={meta.buildingPartType}
            apartmentType={meta.apartmentType}
            data={meta.data}
            onRegionChange={meta.onRegionChange}
            onDistrictChange={meta.onDistrictChange}
            setData={meta.setData}
            setShowModal={meta.setShowModal}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>

      <AddCityModal open={meta.showModal} onClose={meta.setShowModal} />
    </div>
  );
};

export default NativeAddress;
