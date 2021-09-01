import React from 'react';

import CustomDatePicker from '../../../../../../components/CustomDatePicker/CustomDatePicker';

const ArchiveFilterPeriod = () => (
  <div className="period">
    <div className="period__picker">
      <CustomDatePicker
        label="Від"
        onSelect={(e) => console.log(e)}
      />
    </div>
    <div className="period__picker">
      <CustomDatePicker
        label="По"
        onSelect={(e) => console.log(e)}
      />
    </div>
  </div>
);

export default ArchiveFilterPeriod;
