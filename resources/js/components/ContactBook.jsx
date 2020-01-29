import React from 'react';
import ReactDOM from 'react-dom';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCog, faPlus } from '@fortawesome/free-solid-svg-icons';

import Header from '@components/Header';
import Main from '@components/Main';
import Footer from '@components/Footer';

import styled from './styled';

library.add(faCog, faPlus);

const ContactBook = () => (
  <styled.ContactBook>
    <Header />
    <Main />
    <Footer />
  </styled.ContactBook>
);

ReactDOM.render(<ContactBook />, document.getElementById('contact-book'));
