import React from 'react';

import Navigation from '@components/Navigation';

import styled from './styled';

const Header = () => (
  <styled.Header>
    <styled.Sitename>
      ContactBook
    </styled.Sitename>
    <Navigation />
  </styled.Header>
);

export default Header;
